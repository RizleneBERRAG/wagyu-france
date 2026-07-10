<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $requestItem->reference }}</title>
</head>
<body style="margin:0;background:#f4eee6;color:#2a241f;font-family:Arial,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f4eee6;padding:32px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:680px;background:#fffdf9;border:1px solid #ded3c6;">
                <tr>
                    <td style="padding:32px;background:#2b2520;color:#fff;">
                        <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#c9a77f;">Wagyu France</div>
                        <h1 style="margin:12px 0 0;font-family:Georgia,serif;font-size:34px;font-weight:400;">
                            {{ $forAdmin ? 'Nouvelle demande reçue' : 'Votre demande est bien enregistrée' }}
                        </h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:32px;">
                        <p style="margin:0 0 20px;line-height:1.7;">
                            @if ($forAdmin)
                                Une nouvelle demande doit être consultée dans le tableau de bord.
                            @else
                                Bonjour {{ $requestItem->fullname }}, votre message a bien été transmis à la maison Wagyu France.
                                Nous reviendrons vers vous {{ config('wagyu.reply_delay', 'dans les meilleurs délais') }}.
                            @endif
                        </p>

                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f7f1e9;border:1px solid #e3d8ca;margin:0 0 24px;">
                            <tr><td style="padding:14px 18px;color:#7e6e5d;font-size:12px;text-transform:uppercase;letter-spacing:1px;">Référence</td><td style="padding:14px 18px;text-align:right;font-weight:bold;">{{ $requestItem->reference }}</td></tr>
                            <tr><td style="padding:14px 18px;color:#7e6e5d;font-size:12px;text-transform:uppercase;letter-spacing:1px;border-top:1px solid #e3d8ca;">Type</td><td style="padding:14px 18px;text-align:right;border-top:1px solid #e3d8ca;">{{ $kind === 'shop' ? 'Boutique particulier' : ($kind === 'pro' ? 'Réserve professionnelle' : 'Contact') }}</td></tr>
                            @if ($kind === 'shop')
                                <tr><td style="padding:14px 18px;color:#7e6e5d;font-size:12px;text-transform:uppercase;letter-spacing:1px;border-top:1px solid #e3d8ca;">Estimation</td><td style="padding:14px 18px;text-align:right;border-top:1px solid #e3d8ca;">{{ number_format((float) $requestItem->total, 2, ',', ' ') }} €</td></tr>
                            @elseif ($kind === 'pro')
                                <tr><td style="padding:14px 18px;color:#7e6e5d;font-size:12px;text-transform:uppercase;letter-spacing:1px;border-top:1px solid #e3d8ca;">Estimation HT</td><td style="padding:14px 18px;text-align:right;border-top:1px solid #e3d8ca;">{{ number_format((float) $requestItem->total_ht, 2, ',', ' ') }} € HT</td></tr>
                            @else
                                <tr><td style="padding:14px 18px;color:#7e6e5d;font-size:12px;text-transform:uppercase;letter-spacing:1px;border-top:1px solid #e3d8ca;">Objet</td><td style="padding:14px 18px;text-align:right;border-top:1px solid #e3d8ca;">{{ $requestItem->subject }}</td></tr>
                            @endif
                        </table>

                        @if ($forAdmin)
                            <p style="margin:0 0 8px;"><strong>Contact :</strong> {{ $requestItem->fullname }}</p>
                            <p style="margin:0 0 8px;"><strong>Email :</strong> {{ $requestItem->email }}</p>
                            @if ($requestItem->phone)<p style="margin:0 0 8px;"><strong>Téléphone :</strong> {{ $requestItem->phone }}</p>@endif
                            @if ($requestItem->message)<p style="margin:18px 0 0;line-height:1.7;"><strong>Message :</strong><br>{{ $requestItem->message }}</p>@endif
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="padding:22px 32px;background:#8d2024;color:#fff;font-size:13px;line-height:1.6;">
                        Cette demande n’est définitive qu’après confirmation explicite des disponibilités, quantités et modalités par Wagyu France.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>