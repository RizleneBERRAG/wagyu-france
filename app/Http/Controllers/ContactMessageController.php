<?php

namespace App\Http\Controllers;

use App\Mail\RequestReceivedMail;
use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ContactMessageController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'audience' => ['required', 'string', Rule::in(['particulier', 'professionnel', 'partenaire'])],
            'fullname' => ['required', 'string', 'max:190'],
            'email' => ['required', 'email', 'max:190'],
            'phone' => ['nullable', 'string', 'max:40'],
            'company' => ['nullable', 'string', 'max:190'],
            'city' => ['nullable', 'string', 'max:120'],
            'subject' => ['required', 'string', 'max:190'],
            'message' => ['required', 'string', 'min:10', 'max:5000'],
            'preferred_contact' => ['required', 'string', Rule::in(['email', 'telephone'])],
            'privacy' => ['accepted'],
        ], [
            'audience.required' => 'Précisez le type de demande.',
            'fullname.required' => 'Le nom complet est obligatoire.',
            'email.required' => 'L’adresse email est obligatoire.',
            'email.email' => 'L’adresse email n’est pas valide.',
            'subject.required' => 'Le motif de la demande est obligatoire.',
            'message.required' => 'Le message est obligatoire.',
            'message.min' => 'Le message doit contenir au moins 10 caractères.',
            'preferred_contact.required' => 'Choisissez votre moyen de contact préféré.',
            'privacy.accepted' => 'Vous devez accepter la politique de confidentialité.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Certaines informations sont manquantes ou invalides.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $message = ContactMessage::create([
            'reference' => $this->generateReference(),
            'audience' => $validated['audience'],
            'fullname' => $validated['fullname'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'company' => $validated['company'] ?? null,
            'city' => $validated['city'] ?? null,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'preferred_contact' => $validated['preferred_contact'],
            'status' => 'nouvelle',
            'privacy_accepted_at' => now(),
        ]);

        $this->sendEmails($message);

        return response()->json([
            'message' => 'Votre message a bien été transmis à Wagyu France.',
            'reference' => $message->reference,
        ], 201);
    }

    private function sendEmails(ContactMessage $message): void
    {
        try {
            $adminEmail = config('wagyu.contact_notification_email');

            if ($adminEmail) {
                Mail::to($adminEmail)->send(new RequestReceivedMail('contact', $message, true));
            }

            Mail::to($message->email)->send(new RequestReceivedMail('contact', $message));
        } catch (\Throwable $exception) {
            Log::warning('Erreur envoi email contact Wagyu France', [
                'contact_id' => $message->id,
                'reference' => $message->reference,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function generateReference(): string
    {
        do {
            $reference = 'WF-CONTACT-' . now()->format('Ymd') . '-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));
        } while (ContactMessage::where('reference', $reference)->exists());

        return $reference;
    }
}