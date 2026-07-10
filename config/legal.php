<?php

return [
    'brand_name' => env('LEGAL_BRAND_NAME', 'Wagyu France'),
    'site_url' => env('APP_URL', 'http://localhost'),
    'last_updated' => env('LEGAL_LAST_UPDATED', '10 juillet 2026'),

    'company' => [
        'legal_name' => env('LEGAL_COMPANY_NAME'),
        'legal_form' => env('LEGAL_COMPANY_FORM'),
        'capital' => env('LEGAL_COMPANY_CAPITAL'),
        'address' => env('LEGAL_COMPANY_ADDRESS', 'Ferme du Bois des Huttes, 02140 Landouzy-la-Ville, France'),
        'siren' => env('LEGAL_COMPANY_SIREN'),
        'siret' => env('LEGAL_COMPANY_SIRET'),
        'rcs' => env('LEGAL_COMPANY_RCS'),
        'rne' => env('LEGAL_COMPANY_RNE'),
        'vat' => env('LEGAL_COMPANY_VAT'),
        'email' => env('LEGAL_CONTACT_EMAIL'),
        'phone' => env('LEGAL_CONTACT_PHONE'),
        'publication_director' => env('LEGAL_PUBLICATION_DIRECTOR'),
    ],

    'hosting' => [
        'name' => env('LEGAL_HOST_NAME'),
        'legal_name' => env('LEGAL_HOST_LEGAL_NAME'),
        'address' => env('LEGAL_HOST_ADDRESS'),
        'phone' => env('LEGAL_HOST_PHONE'),
    ],

    'mediator' => [
        'name' => env('LEGAL_MEDIATOR_NAME'),
        'address' => env('LEGAL_MEDIATOR_ADDRESS'),
        'website' => env('LEGAL_MEDIATOR_WEBSITE'),
    ],

    'sales' => [
        'delivery_area' => env('LEGAL_DELIVERY_AREA', 'France métropolitaine, sous réserve de confirmation'),
        'withdrawal_address' => env('LEGAL_WITHDRAWAL_ADDRESS'),
        'complaints_email' => env('LEGAL_COMPLAINTS_EMAIL', env('LEGAL_CONTACT_EMAIL')),
    ],

    'privacy' => [
        'contact_email' => env('LEGAL_PRIVACY_EMAIL', env('LEGAL_CONTACT_EMAIL')),
        'contact_retention' => env('LEGAL_CONTACT_RETENTION', '3 ans à compter du dernier échange actif'),
        'commercial_retention' => env('LEGAL_COMMERCIAL_RETENTION', 'pendant la relation commerciale, puis 5 ans en archivage intermédiaire'),
        'accounting_retention' => env('LEGAL_ACCOUNTING_RETENTION', '10 ans pour les pièces comptables et justificatifs concernés'),
        'technical_logs_retention' => env('LEGAL_LOGS_RETENTION', '12 mois maximum, sauf nécessité de sécurité ou obligation légale'),
    ],
];
