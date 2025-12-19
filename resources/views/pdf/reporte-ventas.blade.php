<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Ventas - HardInfinity</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #333; }
        .container { padding: 30px; }
        .header {
            border-bottom: 3px solid #0ea5e9;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo { font-size: 24px; font-weight: bold; color: #000; }
        .logo span { color: #0ea5e9; }
        .title { font-size: 18px; font-weight: bold; color: #0ea5e9; margin-top: 10px; }
        .subtitle { color: #666; font-size: 10px; margin-top: 5px; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin: 25px 0;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #0ea5e9;
        }
        .stat-label { font-size: 10px; color: #666; text-transform: uppercase; font-weight: bold; }
        .stat-value { font-size: 20px; font-weight: bold; color: #000; margin-top: 5px; }
        .section { margin: 25px 0; }
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #0ea5e9;
            border-bottom: 2px solid #e0e0e0;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background-color: #f5f5f5; }
        th {
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #0ea5e9;
            font-size: 10px;
        }
        td { padding: 8px; border-bottom: 1px solid #e0e0e0; font-size: 10px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #999;
            font-size: 9px;
            border-top: 1px solid #e0e0e0;
            padding-top: 15px;
        }
        .highlight { background-color: #fef3c7; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo"><span>Hard</span>Infinity</div>
            <div class="title">📊 REPORTE DE VENTAS</div>
            <div class="subtitle">Período: {{ $stats['periodo'] }}</div>
        </div>

        <!-- Estadísticas Generales -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Ingresos</div>
                <div class="stat-value">S/ {{ number_format($stats['total_ingresos'], 2) }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Órdenes Procesadas</div>
                <div class="stat-value">{{ $stats['total_ordenes'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Productos Vendidos</div>
                <div class="stat-value">{{ $stats['total_productos_vendidos'] }}</div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Ticket Promedio</div>
                <div class="stat-value">S/ {{ number_format($stats['ticket_promedio'], 2) }}</div>
            </div>
        </div>

        <!-- Productos Más Vendidos -->
        <div class="section">
            <div class="section-title">🏆 TOP 10 - PRODUCTOS MÁS VENDIDOS</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">#</th>
                        <th style="width: 50%;">Producto</th>
                        <th style="width: 20%;">Marca</th>
                        <th style="width: 15%;" class="text-right">Unidades</th>
                        <th style="width: 15%;" class="text-right">Precio Unit.</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topProductos as $index => $producto)
                    <tr class="{{ $index < 3 ? 'highlight' : '' }}">
                        <td class="text-center"><strong>{{ $index + 1 }}</strong></td>
                        <td>{{ $producto->name }}</td>
                        <td>{{ $producto->brand->name ?? 'N/A' }}</td>
                        <td class="text-right"><strong>{{ $producto->order_items_count }}</strong></td>
                        <td class="text-right">S/ {{ number_format($producto->price, 2) }}</td>
                    </tr>
                    @endforeach
                    @if($topProductos->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center" style="padding: 20px; color: #999;">
                            No hay datos de ventas en este período
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        <!-- Ventas por Día -->
        @if($ventasPorDia->isNotEmpty())
        <div class="section">
            <div class="section-title">📅 VENTAS POR DÍA</div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 30%;">Fecha</th>
                        <th style="width: 25%;" class="text-center">Órdenes</th>
                        <th style="width: 45%;" class="text-right">Total Ingresos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ventasPorDia as $dia)
                    <tr>
                        <td>{{ $dia['fecha'] }}</td>
                        <td class="text-center">{{ $dia['ordenes'] }}</td>
                        <td class="text-right"><strong>S/ {{ number_format($dia['total'], 2) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p><strong>HardInfinity</strong> - Sistema de Gestión E-Commerce</p>
            <p>Reporte generado el {{ $generado }}</p>
        </div>
    </div>
</body>
</html>

