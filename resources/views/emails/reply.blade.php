<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Balasan Pesan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #6c5ce7;
            color: white;
            padding: 15px 20px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-left: 1px solid #ddd;
            border-right: 1px solid #ddd;
        }
        .reply-box {
            background-color: #fff;
            padding: 15px;
            border-left: 4px solid #6c5ce7;
            margin-bottom: 20px;
            white-space: pre-line;
        }
        .original-message {
            font-size: 0.9em;
            color: #666;
            margin-top: 30px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .footer {
            background-color: #eee;
            padding: 15px 20px;
            text-align: center;
            font-size: 0.8em;
            color: #666;
            border-radius: 0 0 8px 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2 style="margin: 0;">Halo, {{ $contactMessage->name }}!</h2>
    </div>
    
    <div class="content">
        <p>Terima kasih telah menghubungi kami. Berikut adalah balasan untuk pesan Anda:</p>
        
        <div class="reply-box">
            {{ $replyBody }}
        </div>

        <div style="text-align: center; margin: 30px 0;">
            <p style="color: #ef4444; font-weight: bold; margin-bottom: 15px;">PENTING: Mohon JANGAN membalas (reply) langsung dari aplikasi email ini!</p>
            <a href="{{ route('ticket.show', $contactMessage->ticket_id) }}" style="background-color: #6c5ce7; color: white; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;">
                Klik Di Sini Untuk Membalas Pesan
            </a>
            <p style="font-size: 0.85em; color: #666; margin-top: 10px;">(Atau klik link ini: <a href="{{ route('ticket.show', $contactMessage->ticket_id) }}">{{ route('ticket.show', $contactMessage->ticket_id) }}</a>)</p>
        </div>
        
        <div class="original-message">
            <strong>Pesan Anda sebelumnya:</strong><br>
            <em style="white-space: pre-line;">"{{ $contactMessage->message }}"</em>
        </div>
    </div>
    
    <div class="footer">
        Email ini dikirim secara otomatis. Mohon jangan membalas langsung ke alamat ini jika ini adalah layanan noreply.
    </div>
</body>
</html>
