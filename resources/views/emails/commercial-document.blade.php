<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $heading }}</title>
</head>
<body style="margin:0;background:#f4efe7;font-family:Arial,Helvetica,sans-serif;color:#302821;">
<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4efe7;padding:28px 12px;">
    <tr>
        <td align="center">
            <table role="presentation" width="620" cellspacing="0" cellpadding="0" style="max-width:620px;width:100%;background:#fffdf9;border:1px solid #e2d8cb;">
                <tr>
                    <td style="padding:30px 34px;background:#581818;color:#fff;">
                        <div style="font-size:12px;letter-spacing:2px;text-transform:uppercase;color:#d6ad73;font-weight:700;">Wagyu France</div>
                        <h1 style="margin:10px 0 0;font-family:Georgia,serif;font-size:30px;font-weight:500;">{{ $heading }}</h1>
                    </td>
                </tr>
                <tr>
                    <td style="padding:34px;">
                        <p style="margin:0 0 18px;font-size:15px;line-height:1.7;">Bonjour,</p>
                        <p style="margin:0 0 22px;font-size:15px;line-height:1.7;">{{ $intro }}</p>
                        <div style="padding:18px 20px;background:#f7f1e9;border-left:4px solid #b58b4c;">
                            <div style="font-size:11px;letter-spacing:1.4px;text-transform:uppercase;color:#8a6a45;font-weight:700;">Référence</div>
                            <div style="margin-top:7px;font-size:17px;font-weight:700;color:#581818;">{{ $reference }}</div>
                        </div>
                        <p style="margin:24px 0 0;font-size:14px;line-height:1.7;color:#6f6257;">
                            Le document PDF est joint à cet email. Conservez-le avec vos autres pièces commerciales.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px 34px;border-top:1px solid #e2d8cb;font-size:12px;line-height:1.6;color:#796d62;">
                        Wagyu France · Ce message a été envoyé automatiquement depuis votre dossier.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
