<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #0F1419;
            color: #ffffff;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #151A23;
            border-radius: 12px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            font-size: 32px;
            font-weight: bold;
            color: white;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
        }
        .order-info {
            background-color: #1E2532;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .order-number {
            font-size: 24px;
            font-weight: bold;
            color: #3B82F6;
            margin-bottom: 10px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid #2A3441;
        }
        .item:last-child {
            border-bottom: none;
        }
        .total {
            background-color: #3B82F6;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            padding: 15px 40px;
            background: linear-gradient(135deg, #3B82F6 0%, #8B5CF6 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 30px;
            color: #6B7280;
            font-size: 14px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin: 10px 0;
            font-size: 14px;
        }
        .label {
            color: #9CA3AF;
        }
        .value {
            color: #ffffff;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">⚡ HardInfinity</div>
            <p style="margin: 0; font-size: 18px;">¡Gracias por tu compra!</p>
        </div>
        
        <div class="content">
            <h2 style="color: #ffffff; margin-top: 0;">Hola {{ $order->user->name }},</h2>
            <p style="color: #9CA3AF; line-height: 1.6;">
                Tu pedido ha sido recibido exitosamente y está siendo procesado. 
                A continuación encontrarás los detalles de tu compra:
            </p>
            
            <div class="order-info">
                <div class="order-number">Pedido #{{ $order->order_number }}</div>
                
                <div class="info-row">
                    <span class="label">Fecha:</span>
                    <span class="value">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Estado:</span>
                    <span class="value" style="color: #10B981;">{{ ucfirst($order->status) }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Método de Pago:</span>
                    <span class="value">{{ ucfirst($order->payment_method) }}</span>
                </div>
                
                @if($order->shipping_address)
                <div class="info-row" style="margin-top: 15px; padding-top: 15px; border-top: 1px solid #2A3441;">
                    <span class="label">Dirección de Envío:</span>
                </div>
                <div style="color: #ffffff; margin-top: 5px; font-size: 14px;">
                    {{ $order->shipping_address }}
                </div>
                @endif
            </div>
            
            <h3 style="color: #ffffff; margin-top: 30px;">Productos:</h3>
            
            @foreach($order->items as $item)
            <div class="item">
                <div>
                    <div style="font-weight: 600; color: #ffffff;">{{ $item->product->name ?? 'Producto' }}</div>
                    <div style="color: #9CA3AF; font-size: 14px;">Cantidad: {{ $item->quantity }}</div>
                </div>
                <div style="font-weight: 600; color: #3B82F6;">
                    S/ {{ number_format($item->unit_price * $item->quantity, 2) }}
                </div>
            </div>
            @endforeach
            
            <div class="total">
                Total: S/ {{ number_format($order->total_amount, 2) }}
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('profile.orders') }}" class="button">
                    Ver Detalles del Pedido
                </a>
            </div>
            
            <p style="color: #9CA3AF; line-height: 1.6; margin-top: 30px; font-size: 14px;">
                <strong>¿Necesitas ayuda?</strong><br>
                Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos. 
                Estamos aquí para ayudarte.
            </p>
        </div>
        
        <div class="footer">
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
            <p style="margin: 5px 0;">© {{ date('Y') }} HardInfinity. Todos los derechos reservados.</p>
            <p style="margin: 5px 0;">🚀 Tecnología de vanguardia para gamers exigentes</p>
        </div>
    </div>
</body>
</html>

