<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 10px;
        color: #222;
    }

    .header {
        width: 100%;
        border-bottom: 3px solid #a52119;
        margin-bottom: 10px;
    }

    .header img {
        height: 60px;
    }

    .title {
        text-align: center;
        font-weight: bold;
        font-size: 14px;
        margin: 10px 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    th {
        background: #a52119;
        color: white;
        border: 1px solid #333;
        padding: 4px;
        text-align: center;
    }

    td {
        border: 1px solid #333;
        padding: 3px;
        text-align: center;
    }

    .estatus-planeado {
        background: #f5d7d5;
        font-weight: bold;
    }

    .estatus-realizado {
        background: #c9e6d3;
        font-weight: bold;
    }

    .footer {
        margin-top: 20px;
        font-size: 9px;
        text-align: center;
        color: #555;
    }
</style>
</head>

<body>

<div class="header">
    <table>
        <tr>
            <td style="width:20%">
                <img src="<?= FCPATH ?>assets/img/uptx_logo.png">
            </td>
            <td style="width:60%; text-align:center;">
                <strong>Programa Anual de Mantenimiento a Laboratorios</strong><br>
                Año <?= $anio ?>
            </td>
            <td style="width:20%; text-align:right;">
                Sistema de Gestión de la Calidad
            </td>
        </tr>
    </table>
</div>

<div class="title">Programa Anual de Mantenimiento</div>

<table>
    <thead>
        <tr>
            <th>Laboratorio</th>
            <th>Actividad</th>
            <th>Estatus</th>
            <th>Ene</th><th>Feb</th><th>Mar</th><th>Abr</th>
            <th>May</th><th>Jun</th><th>Jul</th><th>Ago</th>
            <th>Sep</th><th>Oct</th><th>Nov</th><th>Dic</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($laboratorios as $row): ?>
        <tr>
            <td><?= $row->nombre ?></td>
            <td><?= $row->actividad ?></td>
            <td class="<?= $row->estatus == 'REALIZADO' ? 'estatus-realizado' : 'estatus-planeado' ?>">
                <?= $row->estatus ?>
            </td>
            <?php for ($i=1; $i<=12; $i++): ?>
                <td>X</td>
            <?php endfor; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<div class="footer">
    Para uso de la Universidad Politécnica de Tlaxcala mediante su Sistema de Gestión de la Calidad
</div>

</body>
</html>