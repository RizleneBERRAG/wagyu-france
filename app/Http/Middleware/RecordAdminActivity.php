<?php

namespace App\Http\Middleware;

use App\Services\AdminActivityService;
use Closure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordAdminActivity
{
    public function __construct(private readonly AdminActivityService $activity)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'], true)
            || $response->getStatusCode() >= 400
            || ! $request->user()) {
            return $response;
        }

        $routeName = (string) optional($request->route())->getName();

        if ($routeName === 'admin.logout') {
            return $response;
        }

        $subject = $this->subject($request);
        $action = $this->action($routeName, $request->method());
        $description = $this->description($routeName, $subject);

        $this->activity->record(
            $action,
            $description,
            $subject,
            $this->safeProperties($request),
            $request->user(),
            $request
        );

        return $response;
    }

    private function subject(Request $request): ?Model
    {
        foreach ((array) optional($request->route())->parameters() as $parameter) {
            if ($parameter instanceof Model) {
                return $parameter;
            }
        }

        return null;
    }

    private function action(string $routeName, string $method): string
    {
        return match (true) {
            str_contains($routeName, 'products') => 'catalogue.' . strtolower($method),
            str_contains($routeName, 'animals') => 'reserve.' . strtolower($method),
            str_contains($routeName, 'customers') => 'crm.' . strtolower($method),
            str_contains($routeName, 'billing') => 'billing.' . strtolower($method),
            str_contains($routeName, 'documents') => 'documents.' . strtolower($method),
            str_contains($routeName, 'logistics') => 'logistics.' . strtolower($method),
            str_contains($routeName, 'demandes') => 'requests.' . strtolower($method),
            str_contains($routeName, 'settings') => 'settings.' . strtolower($method),
            str_contains($routeName, 'users') => 'users.' . strtolower($method),
            default => 'admin.' . strtolower($method),
        };
    }

    private function description(string $routeName, ?Model $subject): string
    {
        $label = $subject ? ' « ' . $this->activity->subjectLabel($subject) . ' »' : '';

        return match ($routeName) {
            'admin.products.store' => 'Création d’un produit boutique.',
            'admin.products.update' => 'Modification du produit' . $label . '.',
            'admin.products.toggle' => 'Changement de visibilité du produit' . $label . '.',
            'admin.products.destroy' => 'Suppression du produit' . $label . '.',
            'admin.animals.store' => 'Création d’un animal de réserve.',
            'admin.animals.update' => 'Modification de l’animal' . $label . '.',
            'admin.animals.activate' => 'Publication de l’animal' . $label . '.',
            'admin.animals.destroy' => 'Suppression de l’animal' . $label . '.',
            'admin.animals.cuts.update' => 'Modification d’une pièce de l’animal' . $label . '.',
            'admin.demandes.shop.status', 'admin.demandes.pro.status', 'admin.demandes.contact.status' => 'Changement de statut du dossier' . $label . '.',
            'admin.documents.shop.update', 'admin.documents.pro.update' => 'Mise à jour commerciale du dossier' . $label . '.',
            'admin.documents.shop.invoice.issue', 'admin.documents.pro.invoice.issue' => 'Émission d’une facture pour le dossier' . $label . '.',
            'admin.billing.shop.invoice.send', 'admin.billing.pro.invoice.send' => 'Envoi d’une facture pour le dossier' . $label . '.',
            'admin.billing.shop.credit.issue', 'admin.billing.pro.credit.issue' => 'Émission d’un avoir pour le dossier' . $label . '.',
            'admin.billing.credit.send' => 'Envoi d’un avoir' . $label . '.',
            'admin.logistics.shop.update', 'admin.logistics.pro.update' => 'Mise à jour logistique du dossier' . $label . '.',
            'admin.customers.store' => 'Création manuelle d’une fiche CRM.',
            'admin.customers.update' => 'Modification de la fiche client' . $label . '.',
            'admin.customers.interactions.store' => 'Ajout d’une interaction CRM' . $label . '.',
            'admin.customers.interactions.complete' => 'Relance CRM marquée comme effectuée' . $label . '.',
            'admin.settings.update' => 'Modification des paramètres du site.',
            'admin.users.store' => 'Création d’un compte administrateur.',
            'admin.users.update' => 'Modification du compte administrateur' . $label . '.',
            'admin.users.toggle' => 'Activation ou désactivation du compte administrateur' . $label . '.',
            default => 'Action administrative effectuée sur ' . ($routeName ?: 'une route interne') . $label . '.',
        };
    }

    private function safeProperties(Request $request): array
    {
        $allowedValues = [
            'status',
            'preparation_status',
            'payment_status',
            'relationship_status',
            'role',
            'type',
            'is_active',
        ];

        $values = collect($request->only($allowedValues))
            ->reject(fn ($value) => $value === null || $value === '')
            ->all();

        $ignored = ['_token', '_method', 'password', 'password_confirmation'];
        $changedFields = collect(array_keys($request->except($ignored)))
            ->filter(fn ($key) => ! str_contains($key, 'password'))
            ->values()
            ->all();

        return array_filter([
            'route' => optional($request->route())->getName(),
            'method' => $request->method(),
            'values' => $values === [] ? null : $values,
            'changed_fields' => $changedFields,
        ], fn ($value) => $value !== null && $value !== []);
    }
}
