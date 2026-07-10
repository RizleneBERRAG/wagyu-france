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
            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:660px;background:#fffdf9;border:1px solid #ded3c6;">
                <tr>
                    <td style="padding:32px;background:#2b2520;color:#fff;">
                        <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#c9a77f;">Wagyu France · Suivi</div>
                        <h1 style="margin:12px 0 0;font-family:Georgia,serif;font-size:34px;font-weight:400;">Votre demande évolue.</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:34px;">
                        <p style="margin:0 0 22px;line-height:1.7;">Bonjour {{ $requestItem->fullname }},</p>
                        <p style="margin:0 0 22px;line-height:1.7;">
                            Le statut de votre {{ $kind === 'shop' ? 'demande boutique' : ($kind === 'pro' ? 'demande professionnelle' : 'message') }}
                            a été mis à jour.
                        </p>

                        <div style="padding:24px;border-left:4px solid #8d2024;background:#f7f1e9;margin-bottom:24px;">
                            <div style="color:#8d2024;font-size:12px;letter-spacing:1.4px;text-transform:uppercase;font-weight:bold;">Statut actuel</div>
                            <strong style="display:block;margin-top:9px;font-family:Georgia,serif;font-size:30px;font-weight:400;">{{ $statusLabel }}</strong>
                            <span style="display:block;margin-top:8px;color:#7b6c5d;">Référence {{ $requestItem->reference }}</span>
                        </div>

                        <p style="margin:0;line-height:1.7;">
                            Pour toute précision, répondez directement à cet email ou contactez la maison en rappelant votre référence.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:22px 34px;background:#8d2024;color:#fff;font-size:13px;line-height:1.6;">
                        Wagyu France · {{ config('wagyu.contact_email', config('mail.from.address')) }}
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>