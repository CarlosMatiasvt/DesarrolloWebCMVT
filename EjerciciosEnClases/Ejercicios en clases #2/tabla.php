<?php
$operacion = $_POST['operacion'] ?? 'multiplicacion';
$n = intval($_POST['n'] ?? 1);

$nombres_op = [
    'suma' => 'Tabla de Suma',
    'resta' => 'Tabla de Resta',
    'multiplicacion' => 'Tabla de Multiplicación',
    'division' => 'Tabla de División'
];

$simbolos_op = [
    'suma' => '+',
    'resta' => '-',
    'multiplicacion' => '*',
    'division' => '/'
];

$titulo = $nombres_op[$operacion] ?? 'Tabla de Operación';
$simbolo = $simbolos_op[$operacion] ?? '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo; ?></title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            text-align: center;
            padding: 5px 10px;
        }
        .header-cell {
            background-color: #D9D9D9;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1><?php echo $titulo; ?></h1>
    <table>
        <tr>
            <td class="header-cell"><?php echo $simbolo; ?></td>
            <?php for ($j = 1; $j <= $n; $j++): ?>
                <td class="header-cell"><?php echo $j; ?></td>
            <?php endfor; ?>
        </tr>
        <?php for ($i = 1; $i <= $n; $i++): ?>
            <tr>
                <td class="header-cell"><?php echo $i; ?></td>
                <?php for ($j = 1; $j <= $n; $j++): ?>
                    <td>
                        <?php
                        switch ($operacion) {
                            case 'suma':
                                echo $i + $j;
                                break;
                            case 'resta':
                                echo $i - $j;
                                break;
                            case 'multiplicacion':
                                echo $i * $j;
                                break;
                            case 'division':
                                echo number_format($i / $j, 2);
                                break;
                        }
                        ?>
                    </td>
                <?php endfor; ?>
            </tr>
        <?php endfor; ?>
    </table>
</body>
</html>