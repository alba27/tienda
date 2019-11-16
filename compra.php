<?php

//Comprobación del usuario  
if (isset($_POST['usu'])){
    $usu=strip_tags(trim($_POST['usu']));
}

//Comprobación de la contraseña
if (isset($_POST['con'])){
    $con=strip_tags(trim($_POST['con']));
}

if (empty($usu) or empty($con)){
	$http = "Location: tienda.php?mensaje=".urlencode("Datos incorrectos"); 
    header($http); 
    exit; 
}



//Accede a la base de datos 
include "../../../seguridad/tema04/datosTienda.php";
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}

//Si el canal es correcto, lo mete en utf8 
mysqli_set_charset($canal,"utf8");

//Hacemos la consulta 
$sql="select email,contrasena from usuario where email=? and contrasena=?";

//Busca la secuencia sql en la BBDD
$consulta=mysqli_prepare($canal,$sql); 

//Comprueba que exista la consulta
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}

//Le pasa el valor introducido por el usuario a la consulta
mysqli_stmt_bind_param($consulta,"ss",$usu,$con);

//Ejecuta la sentencia
mysqli_stmt_execute($consulta);
    
//Mete los datos de la consulta ejecutada en la siguientes variables 
mysqli_stmt_bind_result($consulta, $usuario, $contrasena);

mysqli_stmt_store_result($consulta);

$n=mysqli_stmt_num_rows($consulta);
if ($n!=1){
	$http="Location: tienda.php?mensaje=".urlencode("Datos incorrectos");
	header($http);
	exit;
}

mysqli_stmt_close($consulta);

?>



<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/compra.css">
</head>

<body>
    <!-- *****  Cabecera  ***** -->
    <header>
        <img src="img/logo.png">
        <h1>R&amp;C</h1>
        <a href="#">Cerrar sesión</a>
    </header>
    <!-- *****  Contenido principal  ***** -->
    <main>
        <table>
            <tr>
                <th>NOMBRE</th><th>IMAGEN</th><th>PRECIO</th><th>CANTIDAD</th>
            </tr>
            
            <?php
               			       
                //Generamos la consulta
                $sql="select nombre,imagen,precio from producto";
                $consulta=mysqli_prepare($canal,$sql);
                if (!$consulta){
                    echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
                    exit;
                }            
            
                mysqli_stmt_execute($consulta);
                mysqli_stmt_bind_result($consulta,$nombre,$imagen,$precio);
            
            
                while(mysqli_stmt_fetch($consulta)){
                    echo "<tr><td>$nombre</td><td><img src='$imagen'></td><td>$precio</td></td><td><input type='number'/></td></tr>";
                }
                //Deja de buscar en la base de datos
                mysqli_stmt_close($consulta);
                //Cierra la base de datos
                mysqli_close($canal); 
        ?>
	   </table>
       <form action="factura.php">
           <input type="submit" value="Añadir al carrito"/>
       </form>
    </main>
    <!-- *****  Pie de página  ***** -->
    <footer>
        <div>
            <a href="https://es-es.facebook.com/">
                <img src="img/facebook.png" class="iconos">
            </a>
            <a href="https://www.instagram.com/">
                <img src="img/insta.png" class="iconos">
            </a>
            <a href="https://twitter.com/?lang=es">
                <img src="img/twitter.png" class="iconos">
            </a>
        </div>
        <a href="tienda.php">Volver</a>
    </footer>
</body>

</html>



        