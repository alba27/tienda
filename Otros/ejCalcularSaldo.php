<?php

/*
Recibo por POST el parametro ccc
Preparo la sentencia SQL. Recuerda realizar el include para recuperar los datos de acceso a la BBDD (datosBD.php)
Codificación utf-8
PISTA: el parámetro que le pasamos (ccc) lo concatenamos en la sentencia SQL así:
 $sql="select cl.dni, cl.nombre, cu.fechaalta , sum(m.cantidad) 
		from clientes cl, cuentas cu, posee p, movimientos m 
		where cu.ccc=p.ccc and p.dni=cl.dni and m.ccc=cu.ccc and cu.ccc=?";
		
mysqli_stmt_bind_param($consulta,"s",$cuentacorr);
Si no se introduce numero de cuenta (está vacío) se redirige a solicitarSaldo.php, concatenando un mensaje "Se necesita un número de cuenta"
*/


//Comprobación de datos
if (isset($_POST['ccc'])){
    $ccc=strip_tags($_POST['ccc']);
}

if (empty($ccc)){
	header("Location: ejSolicitarSaldo.php?mensaje=".urlencode("Se necesita un número de cuenta")); 
    exit; 
}

//Accede a la base de datos 
include "../../seguridad/tema03/datosBD.php";
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}

//Si el canal es correcto, lo mete en utf8 
mysqli_set_charset($canal,"utf8");

//Hacemos la consulta 
$sql="select cl.dni, cl.nombre, cu.fechaalta , sum(m.cantidad) 
		from clientes cl, cuentas cu, posee p, movimientos m 
		where cu.ccc=p.ccc and p.dni=cl.dni and m.ccc=cu.ccc and cu.ccc=?";

//Busca la secuencia sql en la BBDD
$consulta=mysqli_prepare($canal,$sql); 

//Comprueba que exista la consulta
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}

//Le pasa el valor introducido por el usuario a la consulta
mysqli_stmt_bind_param($consulta,"s",$ccc);

//Ejecuta la sentencia
mysqli_stmt_execute($consulta);
    
//Mete los datos de la consulta ejecutada en la siguientes variables (cl.dni => $dni, $cl.nombre => $nombre, etc)
mysqli_stmt_bind_result($consulta, $dni, $nombre, $fechaalta, $cantidad);

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

        table {
            border-collapse: collapse;
        }

        td,
        th {
            border: solid 1px black;
            padding: 5px;
        }

        caption {
            background-color: green;
            color: white;
            text-align: center;
            font-size: 1.5em;
            font-weight: bold;
        }

        footer {
            position: fixed;
            bottom: 0px;
            width: 100%;
            height: 50px;
            background-color: red;
        }

        footer a {
            color: white;
        }

    </style>
</head>

<body>
    <header>
        Solicitar saldo
    </header>
    <section>
        <article>
            <table>
                <caption>Titulares de la cuenta: <?=$ccc?></caption>
                <tr>
                    <th>DNI</th>
                    <th>NOMBRE</th>
                    <th>Fecha de alta</th>
                </tr>
                <?php 
                    while (mysqli_stmt_fetch($consulta)){
                        echo "<tr><td>$dni</td><td>$nombre</td><td>$fechaalta</td></tr>";
                    }
                    //Deja de buscar en la base de datos
                    mysqli_stmt_close($consulta);
                    //Cierra la base de datos
                    mysqli_close($canal); 
                ?>
            </table>
        </article>
        <article>
            <p>
                Saldo: <span style="background-color: green; padding: 5px; color: white;"><?=$cantidad?></span>
            </p>
                        
        </article>
    </section>
    <footer>
        <a href="ejSolicitarSaldo.php">Volver</a>
    </footer>
</body>

</html>
