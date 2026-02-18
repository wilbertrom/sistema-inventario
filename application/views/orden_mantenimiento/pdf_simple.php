<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orden de Mantenimiento</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            color: #a52119;
            text-align: center;
            border-bottom: 2px solid #a52119;
            padding-bottom: 10px;
        }
        .info {
            margin: 20px 0;
            padding: 10px;
            background: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th {
            background: #a52119;
            color: white;
            padding: 10px;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
    </style>
</head>
<body>
    
    <h1>ORDEN DE MANTENIMIENTO #<?php echo $orden->id; ?></h1>
    
    <div class="info">
        <p><strong>Laboratorio:</strong> <?php echo $laboratorio_nombre; ?></p>
        <p><strong>Área Solicitante:</strong> <?php echo $orden->area_solicitante; ?></p>
        <p><strong>Solicitante:</strong> <?php echo $orden->solicitante; ?></p>
        <p><strong>Fecha de Elaboración:</strong> <?php echo $orden->fecha_elaboracion; ?></p>
    </div>
    
    <h3>Descripción del Servicio</h3>
    <p><?php echo nl2br($orden->descripcion_servicio); ?></p>
    
    <?php if(!empty($orden->especificacion_tecnica)): ?>
    <h3>Especificación Técnica</h3>
    <p><?php echo nl2br($orden->especificacion_tecnica); ?></p>
    <?php endif; ?>
    
    <?php if(!empty($trabajos)): ?>
    <h3>Trabajos Realizados</h3>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Asignado a</th>
                <th>Fecha</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($trabajos as $t): ?>
            <tr>
                <td><?php echo $t->tipo_mantenimiento . ' - ' . $t->tipo_servicio; ?></td>
                <td><?php echo $t->asignado_a ?: $t->empresa_contratista; ?></td>
                <td><?php echo $t->fecha_realizacion; ?></td>
                <td>$<?php echo $t->costo; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
    
    <div class="footer">
        Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad
    </div>
    
</body>
</html>