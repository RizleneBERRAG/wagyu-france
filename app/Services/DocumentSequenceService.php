<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\DB;

class DocumentSequenceService
{
    public function nextInvoiceNumber(): string
    {
        return DB::transaction(function () {
            $year = now()->format('Y');
            $key = 'invoice-' . $year;
            $now = now();

            DB::table('document_sequences')->insertOrIgnore([
                'key' => $key,
                'next_value' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $sequence = DB::table('document_sequences')
                ->where('key', $key)
                ->lockForUpdate()
                ->first();

            $number = max(1, (int) ($sequence->next_value ?? 1));

            DB::table('document_sequences')
                ->where('key', $key)
                ->update([
                    'next_value' => $number + 1,
                    'updated_at' => now(),
                ]);

            $prefix = strtoupper(trim((string) SiteSetting::valueFor('invoice_prefix', 'WF')));
            $prefix = preg_replace('/[^A-Z0-9-]/', '', $prefix) ?: 'WF';

            return sprintf('%s-%s-%04d', $prefix, $year, $number);
        }, 5);
    }
}
