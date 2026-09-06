<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pesan Baru Website SMPN 14 Surabaya</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1F2A44; background: #EDEAD9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #FBFAF5; border: 1px solid #A79E8C; padding: 24px; border-radius: 4px;">
        <h2 style="color: #9B3226; margin-top: 0; border-bottom: 2px solid #1F2A44; padding-bottom: 8px;">Pesan Baru Diterima</h2>
        <p>Halo Administrator,</p>
        <p>Ada pesan masuk baru melalui formulir kontak website resmi SMP Negeri 14 Surabaya:</p>
        
        <table style="width: 100%; border-collapse: collapse; margin: 16px 0;">
            <tr>
                <td style="padding: 6px 0; font-weight: bold; width: 120px;">Pengirim:</td>
                <td style="padding: 6px 0;">{{ $contactMessage->name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold;">Email:</td>
                <td style="padding: 6px 0;">{{ $contactMessage->email }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold;">Telepon/WA:</td>
                <td style="padding: 6px 0;">{{ $contactMessage->phone ?? '-' }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold;">Subjek:</td>
                <td style="padding: 6px 0;">{{ $contactMessage->subject }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; font-weight: bold; vertical-align: top;">Isi Pesan:</td>
                <td style="padding: 6px 0; white-space: pre-line;">{{ $contactMessage->message }}</td>
            </tr>
        </table>

        <p style="font-size: 13px; color: #777; border-top: 1px solid #A79E8C; padding-top: 12px; margin-bottom: 0;">
            Pesan ini dapat dikelola langsung di Admin Panel SMPN 14 Surabaya (Menu Sistem &gt; Pesan Masuk).
        </p>
    </div>
</body>
</html>
