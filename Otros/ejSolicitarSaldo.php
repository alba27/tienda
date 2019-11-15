<?php

/* 
EJERCICIO:
Solicitar saldo a traves un formulario en PHP en el fichero solicitarSaldo.php
El usuario introducirá un número de cuenta ccc y redirigirá a otra página (calcularSaldo.php).
Se le pasará por parámetro el valor del ccc
EL fichero calcularSaldo.php deberá realizar las validaciones (isset, strip_tags...) correspondientes,
asi como la consulta select.
Si no se introduce nada se mostrará el error con el mensaje: "Se necesita un numero de cuenta"

Datos a mostrar: DNI  |   NOMBRE   |   FECHA DE ALTA   |   SALDO
*/


$mensaje="";
if (isset($_GET['mensaje'])){
    $mensaje=strip_tags($_GET['mensaje']);
}

$ccc="";
if(isset($_GET['ccc'])){
    $ccc=strip_tags($_GET['ccc']);
}

?>


<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>Solicitar Saldo</title>
    <style type="text/css">
        header {
            padding: 20px;
            font-size: 2em;
            font-weight: bold;
            background-color: red;
            color: white;
            margin-bottom: 15px;
        }

        section {
            width: 450px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
<body>
    <header>
        Solicitar saldo
    </header>
    <section>
        <p style="color: red"><?=$mensaje?></p>
        <form action="ejCalcularSaldo.php" method="post">
            Número de cuenta (ccc): <input type="text" name="ccc" size="24" maxlength="24" value="<?=$ccc?>" /><br /><br />
            <input type="submit" value="Calcular" />
        </form>

    </section>
</body>

</html>
