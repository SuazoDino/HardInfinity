<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Inventario - HardInfinity</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 10px; color: #333; }
        .container { padding: 30px; }
        .header {
            border-bottom: 3px solid #0ea5e9;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .logo { font-size: 24px; font-weight: bold; color: #000; }
        .logo span { color: #0ea5e9; }
        .title { font-size: 18px; font-weight: bold; color: #0ea5e9; margin-top: 10px; }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin: 20px 0;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 6px;
            border-left: 3px solid #0ea5e9;
            text-align: center;
        }
        .stat-label { font-size: 9px; color: #666; text-transform: uppercase; }
        .stat-value { font-size: 16px; font-weight: bold; color: #000; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        thead { background-color: #f5f5f5; }
        th {
            padding: 8px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #0ea5e9;
            font-size: 9px;
        }
        td { padding: 6px; border-bottom: 1px solid #e0e0e0; font-size: 9px; }
        .text-right { text-align: right; }
        .stock-bajo { background-color: #fee2e2; color: #991b1b; }
        .stock-critico { background-color: #fef3c7; color: #92400e; font-weight: bold; }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 8px;
            border-top: 1px solid #e0e0e0;
            padding-top: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="logo"><span>Hard</span>Infinity</div>
            <div class="title">📦 REPORTE DE INVENTARIO</div>
        </div>

        <!-- Estadísticas -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Productos</div>
                <div class="stat-value"><?php echo e($stats['total_productos']); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Stock Total</div>
                <div class="stat-value"><?php echo e($stats['stock_total']); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Valor Inventario</div>
                <div class="stat-value" style="font-size: 13px;">S/ <?php echo e(number_format($stats['valor_inventario'], 0)); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Stock Bajo</div>
                <div class="stat-value" style="color: #dc2626;"><?php echo e($stats['productos_bajo_stock']); ?></div>
            </div>
            <div class="stat-card">
                <div class="stat-label">Sin Stock</div>
                <div class="stat-value" style="color: #991b1b;"><?php echo e($stats['productos_sin_stock']); ?></div>
            </div>
        </div>

        <!-- Lista de Productos -->
        <div style="margin-top: 25px;">
            <div style="font-size: 12px; font-weight: bold; color: #0ea5e9; border-bottom: 2px solid #e0e0e0; padding-bottom: 6px; margin-bottom: 12px;">
                📋 INVENTARIO DETALLADO
            </div>
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">SKU</th>
                        <th style="width: 35%;">Producto</th>
                        <th style="width: 15%;">Marca</th>
                        <th style="width: 15%;">Categoría</th>
                        <th style="width: 10%;" class="text-right">Stock</th>
                        <th style="width: 10%;" class="text-right">Precio</th>
                        <th style="width: 10%;" class="text-right">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="<?php echo e($producto->stock == 0 ? 'stock-bajo' : ($producto->stock < 10 ? 'stock-critico' : '')); ?>">
                        <td style="font-family: monospace; font-size: 8px;"><?php echo e($producto->sku); ?></td>
                        <td><?php echo e(Str::limit($producto->name, 40)); ?></td>
                        <td><?php echo e($producto->brand->name ?? 'N/A'); ?></td>
                        <td><?php echo e($producto->category->name ?? 'N/A'); ?></td>
                        <td class="text-right"><strong><?php echo e($producto->stock); ?></strong></td>
                        <td class="text-right">S/ <?php echo e(number_format($producto->price, 2)); ?></td>
                        <td class="text-right"><strong>S/ <?php echo e(number_format($producto->stock * $producto->price, 2)); ?></strong></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
                <tfoot>
                    <tr style="background-color: #f0f9ff; font-weight: bold; border-top: 2px solid #0ea5e9;">
                        <td colspan="4" style="text-align: right; padding: 10px;">TOTAL:</td>
                        <td class="text-right"><?php echo e($stats['stock_total']); ?></td>
                        <td></td>
                        <td class="text-right" style="color: #0ea5e9; font-size: 12px;">S/ <?php echo e(number_format($stats['valor_inventario'], 2)); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>HardInfinity</strong> - Sistema de Gestión de Inventario</p>
            <p>Reporte generado el <?php echo e($generado); ?></p>
        </div>
    </div>
</body>
</html>

<?php /**PATH C:\Users\informatica\HardInfinity-1\resources\views/pdf/reporte-inventario.blade.php ENDPATH**/ ?>