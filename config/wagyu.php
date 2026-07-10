<?php

return [
    'admin_password' => env('WF_ADMIN_PASSWORD', ''),
    'contact_email' => env('LEGAL_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS')),
    'contact_phone' => env('LEGAL_CONTACT_PHONE'),
    'reply_delay' => 'Sous 2 jours ouvrés',
    'order_email' => env('WAGYU_ORDER_EMAIL', env('MAIL_FROM_ADDRESS')),
    'pro_email' => env('WAGYU_PRO_EMAIL', env('MAIL_FROM_ADDRESS')),
    'contact_notification_email' => env('WAGYU_CONTACT_EMAIL', env('MAIL_FROM_ADDRESS')),
    'delivery_area' => env('LEGAL_DELIVERY_AREA', 'France métropolitaine, sous réserve de confirmation'),
    'withdrawal_address' => env('LEGAL_WITHDRAWAL_ADDRESS'),
    'preparation_delay' => 'Confirmé individuellement selon la découpe et la disponibilité',
];