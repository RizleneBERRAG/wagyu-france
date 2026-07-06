<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Nouvelle demande pro</title>
</head>
<body style="margin:0;padding:0;background:#070605;font-family:Arial,Helvetica,sans-serif;color:#fff7e8;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#070605;padding:36px 18px;">
    <tr>
        <td align="center">
            <table width="620" cellpadding="0" cellspacing="0" style="max-width:620px;width:100%;background:#11100d;border:1px solid rgba(229,201,130,0.28);border-radius:24px;overflow:hidden;">
                <tr>
                    <td style="padding:34px 34px 20px;">
                        <p style="margin:0 0 10px;color:#e5c982;font-size:12px;font-weight:800;letter-spacing:2px;text-transform:uppercase;">
                            Wagyu France
                        </p>

                        <h1 style="margin:0;color:#fff7e8;font-size:30px;line-height:1.1;">
                            Nouvelle demande professionnelle
                        </h1>

                        <p style="margin:14px 0 0;color:#cfc3aa;font-size:15px;line-height:1.7;">
                            Une nouvelle demande de pré-réservation vient d’être envoyée depuis l’interface professionnelle.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 34px 24px;">
                        <div style="background:#181611;border:1px solid rgba(229,201,130,0.18);border-radius:18px;padding:22px;">
                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Référence :</strong> {{ $reservation->reference }}
                            </p>

                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Bovin :</strong> {{ $reservation->bovin_reference }}
                            </p>

                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Société :</strong> {{ $reservation->company }}
                            </p>

                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Contact :</strong> {{ $reservation->fullname }}
                            </p>

                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Email :</strong> {{ $reservation->email }}
                            </p>

                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Téléphone :</strong> {{ $reservation->phone }}
                            </p>

                            <p style="margin:0 0 8px;color:#fff7e8;">
                                <strong>Type :</strong> {{ $reservation->professional_type }}
                            </p>

                            @if($reservation->city)
                                <p style="margin:0 0 8px;color:#fff7e8;">
                                    <strong>Ville :</strong> {{ $reservation->city }}
                                </p>
                            @endif

                            @if($reservation->message)
                                <p style="margin:18px 0 0;color:#cfc3aa;line-height:1.7;">
                                    <strong style="color:#fff7e8;">Message :</strong><br>
                                    {{ $reservation->message }}
                                </p>
                            @endif
                        </div>
                    </td>
                </tr>

                <tr>
                    <td style="padding:0 34px 24px;">
                        <h2 style="margin:0 0 14px;color:#e5c982;font-size:18px;">
                            Pièces demandées
                        </h2>

                        <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                            <thead>
                            <tr>
                                <th align="left" style="padding:12px;border-bottom:1px solid rgba(229,201,130,0.22);color:#e5c982;font-size:13px;">Pièce</th>
                                <th align="center" style="padding:12px;border-bottom:1px solid rgba(229,201,130,0.22);color:#e5c982;font-size:13px;">Qté</th>
                                <th align="right" style="padding:12px;border-bottom:1px solid rgba(229,201,130,0.22);color:#e5c982;font-size:13px;">Prix HT</th>
                                <th align="right" style="padding:12px;border-bottom:1px solid rgba(229,201,130,0.22);color:#e5c982;font-size:13px;">Total</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($reservation->cart as $item)
                                <tr>
                                    <td style="padding:12px;border-bottom:1px solid rgba(255,255,255,0.06);color:#fff7e8;">
                                        {{ $item['name'] }}
                                    </td>

                                    <td align="center" style="padding:12px;border-bottom:1px solid rgba(255,255,255,0.06);color:#fff7e8;">
                                        {{ $item['quantity'] }} kg
                                    </td>

                                    <td align="right" style="padding:12px;border-bottom:1px solid rgba(255,255,255,0.06);color:#fff7e8;">
                                        {{ number_format($item['unit_price_ht'], 0, ',', ' ') }} €/kg
                                    </td>

                                    <td align="right" style="padding:12px;border-bottom:1px solid rgba(255,255,255,0.06);color:#fff7e8;">
                                        {{ number_format($item['line_total_ht'], 0, ',', ' ') }} €
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <p style="margin:22px 0 0;text-align:right;color:#e5c982;font-size:20px;font-weight:800;">
                            Total estimatif : {{ number_format($reservation->total_ht, 0, ',', ' ') }} € HT
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:24px 34px 34px;">
                        <p style="margin:0;color:#9f947d;font-size:13px;line-height:1.6;">
                            Cette demande est une pré-réservation. Les quantités, disponibilités et modalités de livraison doivent être confirmées par Wagyu France.
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
