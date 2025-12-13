<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden #{{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 3px solid #0ea5e9;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #000;
        }
        .logo span {
            color: #0ea5e9;
        }
        .order-info {
            text-align: right;
        }
        .order-number {
            font-size: 18px;
            font-weight: bold;
            color: #0ea5e9;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            color: #0ea5e9;
            margin-bottom: 10px;
            text-transform: uppercase;
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 5px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 8px;
        }
        .info-label {
            font-weight: bold;
            color: #666;
        }
        .info-value {
            color: #000;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        thead {
            background-color: #f5f5f5;
        }
        th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            color: #333;
            border-bottom: 2px solid #0ea5e9;
        }
        td {
            padding: 10px;
            border-bottom: 1px solid #e0e0e0;
        }
        .text-right {
            text-align: right;
        }
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        .totals-row {
            display: flex;
            justify-content: flex-end;
            padding: 8px 0;
        }
        .totals-label {
            width: 150px;
            text-align: right;
            padding-right: 20px;
            color: #666;
        }
        .totals-value {
            width: 120px;
            text-align: right;
            font-weight: bold;
        }
        .total-final {
            font-size: 18px;
            color: #0ea5e9;
            border-top: 2px solid #0ea5e9;
            padding-top: 10px;
            margin-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-pending { background-color: #fef3c7; color: #92400e; }
        .status-paid { background-color: #dbeafe; color: #1e40af; }
        .status-shipped { background-color: #e0e7ff; color: #3730a3; }
        .status-delivered { background-color: #d1fae5; color: #065f46; }
        .status-cancelled { background-color: #fee2e2; color: #991b1b; }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 10px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header con Logo -->
        <div class="header">
            <div>
                <div class="logo">
                    <span>Hard</span>Infinity
                </div>
                <p style="color: #666; font-size: 11px; margin-top: 5px;">Tienda Especializada en Hardware</p>
            </div>
            <div class="order-info">
                <div class="order-number">ORDEN #{{ $order->order_number }}</div>
                <p style="color: #666; font-size: 11px; margin-top: 3px;">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                <span class="status-badge status-{{ $order->status }}">{{ strtoupper($order->status) }}</span>
            </div>
        </div>

        <!-- Información del Cliente -->
        <div class="section">
            <div class="section-title">📋 Información del Cliente</div>
            <div class="info-grid">
                <div>
                    <div class="info-item">
                        <span class="info-label">Nombre:</span> <span class="info-value">{{ $order->user->name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Email:</span> <span class="info-value">{{ $order->user->email }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Teléfono:</span> <span class="info-value">{{ $order->user->phone ?? 'N/A' }}</span>
                    </div>
                </div>
                <div>
                    <div class="info-item">
                        <span class="info-label">Dirección de Envío:</span>
                        <div class="info-value" style="margin-top: 5px;">{{ $order->shipping_address }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos Ordenados -->
        <div class="section">
            <div class="section-title">📦 Productos</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 50%;">Producto</th>
                        <th style="width: 15%;" class="text-right">Precio Unit.</th>
                        <th style="width: 10%;" class="text-right">Cant.</th>
                        <th style="width: 15%;" class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->product->name }}</strong><br>
                            <span style="color: #666; font-size: 10px;">{{ $item->product->brand->name ?? '' }}</span>
                        </td>
                        <td class="text-right">S/ {{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right"><strong>S/ {{ number_format($item->total_price, 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totales -->
        <div class="totals">
            <div class="totals-row">
                <span class="totals-label">Subtotal:</span>
                <span class="totals-value">S/ {{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="totals-row">
                <span class="totals-label">Costo de Envío:</span>
                <span class="totals-value">
                    @if($order->shipping_cost == 0)
                        <span style="color: #10b981;">GRATIS</span>
                    @else
                        S/ {{ number_format($order->shipping_cost, 2) }}
                    @endif
                </span>
            </div>
            <div class="totals-row">
                <span class="totals-label">Impuestos (IGV 18%):</span>
                <span class="totals-value">S/ {{ number_format($order->tax, 2) }}</span>
            </div>
            <div class="totals-row total-final">
                <span class="totals-label">TOTAL:</span>
                <span class="totals-value">S/ {{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Notas -->
        @if($order->notes)
        <div class="section">
            <div class="section-title">📝 Notas del Pedido</div>
            <p style="color: #666; padding: 10px; background-color: #f9f9f9; border-radius: 5px;">{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>HardInfinity</strong> - Tienda Especializada en Hardware de Alto Rendimiento</p>
            <p>Email: contacto@hardinfinity.com | Teléfono: +51 999 999 999</p>
            <p style="margin-top: 10px;">Documento generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>

