<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resultados del estudio</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <table width="100%" style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 20px; border-radius: 8px;">
        <tr>
            <td>
                <h2 style="color: #333;">Resultados DICOM</h2>
                <p style="font-size: 16px; color: #555;">
                    {!! $bodyText !!}
                </p>
                <hr style="border: none; border-top: 1px solid #ddd; margin: 20px 0;">
                <p style="font-size: 14px; color: #777;">
                    Gracias por confiar en nosotros
                </p>
                <p style="font-size: 14px; color: #777;">
                    Gracias,<br>
                    <strong>{{ config('app.name') }}</strong>
                </p>
            </td>
        </tr>
    </table>
</body>
</html>