<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation demande pro</title>
</head>
<body style="margin:0;padding:0;background:#f8f0e4;font-family:Arial,Helvetica,sans-serif;color:#17120c;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8f0e4;padding:36px 18px;">
    <tr>
        <td align="center">
            <table width="620" cellpadding="0" cellspacing="0" style="max-width:620px;width:100%;background:#fffaf2;border:1px solid rgba(177,132,54,0.24);border-radius:24px;overflow:hidden;">
                <tr>
                    <td style="padding:34px 34px 20px;">
                        <p style="margin:0 0 10px;color:#bd9338;font-size:12px;font-weight:800;letter-spacing:2px;text-transform:uppercase;">
                            Wagyu France
                        </p>

                        <h1 style="margin:0;color:#17120c;font-size:30px;line-height:1.1;">
                            Demande bien enregistrée
                        </h1>

                        <p style="margin:14px 0 0;color:#665744;font-size:15px;line-height:1.7;">
                            Bonjour {{ $reservation->fullname }}, votre demande de pré-réservation professionnelle a bien été enregistrée.
                        </p>

                        <p style="margin:14px 0 0;color:#665744;font-size:15px;line-height:1.7;">
                            Wagyu France reviendra vers vous afin de confirmer les quantités, la disponibilité et les modalités de livraison.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 34px 24px;">
                        <div style="background:#fbf4e8;border:1px solid rgba(177,132,54,0.18);border-radius:18px;padding:22px;">
                            <p style="margin:0 0 8px;color:#17120c;">
                                <strong>Référence :</strong> {{ $reservation->reference }}
                            </p>

                            <p style="margin:0 0 8px;color:#17120c;">
                                <strong>Société :</strong> {{ $reservation->company }}
                            </p>

                            <p style="margin:0 0 8px;color:#17120c;">
                                <strong>Total estimatif :</strong> {{ number_format($reservation->total_ht, 0, ',', ' ') }} € HT
                            </p>
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 34px 24px;">
                        <h2 style="margin:0 0 14px;color:#bd9338;font-size:18px;">
                            Récapitulatif des pièces demandées
                        </h2>

                        @foreach($reservation->cart as $item)
                            <div style="padding:14px 0;border-bottom:1px solid rgba(177,132,54,0.16);">
                                <p style="margin:0;color:#17120c;font-weight:800;">
                                    {{ $item['name'] }}
                                </p>

                                <p style="margin:6px 0 0;color:#665744;">
                                    {{ $item['quantity'] }} kg — {{ number_format($item['unit_price_ht'], 0, ',', ' ') }} €/kg HT
                                </p>
                            </div>
                        @endforeach
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 34px 34px;">
                        <p style="margin:0;color:#7a6b57;font-size:13px;line-height:1.6;">
                            Ce message confirme uniquement la bonne réception de votre demande.
                            Il ne constitue pas une validation définitive de disponibilité.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
