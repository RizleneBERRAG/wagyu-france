<?php

namespace App\Services;

use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class AdminActivityService
{
    public function record(
        string $action,
        string $description,
        Model|null $subject = null,
        array $properties = [],
        User|null $actor = null,
        Request|null $request = null
    ): AdminActivityLog {
        $request ??= request();
        $actor ??= auth()->user();

        return AdminActivityLog::create([
            'user_id' => $actor?->getKey(),
            'action' => $action,
            'subject_type' => $subject ? $subject::class : null,
            'subject_id' => $subject?->getKey(),
            'subject_label' => $subject ? $this->subjectLabel($subject) : null,
            'description' => $description,
            'properties' => $properties === [] ? null : $properties,
            'ip_address' => $request?->ip(),
            'user_agent' => $request?->userAgent(),
        ]);
    }

    public function subjectLabel(Model $subject): string
    {
        foreach (['reference', 'invoice_number', 'number', 'name', 'company', 'fullname', 'email'] as $attribute) {
            $value = $subject->getAttribute($attribute);

            if (filled($value)) {
                return (string) $value;
            }
        }

        return class_basename($subject) . ' #' . $subject->getKey();
    }
}
