<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Receipt</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; color: #111827; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" role="presentation">
        <tr>
            <td align="center" style="padding: 40px 0;">
                <table width="600" cellpadding="0" cellspacing="0" style="background: #ffffff; border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(15,23,42,0.1);">
                    <tr>
                        <td style="background: #0f172a; padding: 32px; text-align: center; color: #f8fafc;">
                            <h1 style="margin: 0; font-size: 28px; letter-spacing: 0.05em;">Cuzzin Finds Receipt</h1>
                            <p style="margin: 8px 0 0; color: #cbd5e1;">Thanks for your order!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 32px; color: #111827;">
                            <p style="margin: 0 0 20px;">Hi {{ $order->name }},</p>
                            <p style="margin: 0 0 24px;">We received your order and will start preparing it soon. Here are the details:</p>

                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse; margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold;">Order ID</td>
                                    <td style="padding: 8px 0; text-align: right;">{{ $order->id }}</td>
                                </tr>
                                <tr style="background: #f8fafc;">
                                    <td style="padding: 8px 0; font-weight: bold;">Total</td>
                                    <td style="padding: 8px 0; text-align: right;">₱{{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; font-weight: bold;">Shipping</td>
                                    <td style="padding: 8px 0; text-align: right; color: #10b981;">FREE</td>
                                </tr>
                                <tr style="background: #f8fafc;">
                                    <td style="padding: 8px 0; font-weight: bold;">Address</td>
                                    <td style="padding: 8px 0; text-align: right;">{{ $order->address }}, {{ $order->city }}</td>
                                </tr>
                            </table>

                            <h2 style="font-size: 16px; margin: 0 0 12px; letter-spacing: 0.05em; text-transform: uppercase; color: #334155;">Items</h2>
                            <table width="100%" cellpadding="0" cellspacing="0" role="presentation" style="border-collapse: collapse;">
                                @foreach($items as $item)
                                    <tr>
                                        <td style="padding: 12px 0; border-bottom: 1px solid #e2e8f0;">{{ $item['name'] }} x{{ $item['quantity'] }}</td>
                                        <td style="padding: 12px 0; text-align: right;">₱{{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>

                            <p style="margin: 24px 0 0; color: #475569;">If you have any questions, reply to this email and we’ll help you out.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background: #0f172a; padding: 24px; text-align: center; color: #e2e8f0; font-size: 12px;">
                            <p style="margin: 0;">Cuzzin Finds • Thank you for shopping with us.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
