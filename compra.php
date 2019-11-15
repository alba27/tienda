<?php

//Accede a la base de datos 
include "../../seguridad/tema04/datosTienda.php";
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}

//Si el canal es correcto, lo mete en utf8 
mysqli_set_charset($canal,"utf8");

//Hacemos la consulta 
$sql="select email,contrasena from usuario where email=?";

//Busca la secuencia sql en la BBDD
$consulta=mysqli_prepare($canal,$sql); 

//Comprueba que exista la consulta
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}

//Le pasa el valor introducido por el usuario a la consulta
mysqli_stmt_bind_param($consulta,"s",$usu);

//Ejecuta la sentencia
mysqli_stmt_execute($consulta);
    
//Mete los datos de la consulta ejecutada en la siguientes variables 
mysqli_stmt_bind_result($consulta, $usuario, $contrasena);




//Comprobación del usuario  
if (isset($_POST['usuario'])){
    $usu=strip_tags($_POST['usuario']);
}

if (empty($usu)){
	header("Location: tienda.php?mensaje=".urlencode("Se necesita un nombre de usuario")); 
    exit; 
}

if($usu != $usuario) {
    header("Location: tienda.php?mensaje=".urlencode("El usuario no es correcto")); 
    exit; 
}

//Comprobación de la contraseña
if (isset($_POST['contrasena'])){
    $con=strip_tags($_POST['contrasena']);
}

if (empty($con)){
	header("Location: tienda.php?mensaje=".urlencode("Se necesita una contraseña")); 
    exit; 
}

if($con != $contrasena) {
    header("Location: tienda.php?mensaje=".urlencode("La contraseña no es correcta")); 
    exit; 
}

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
            <thead>
                <tr>
                    <th>Nombre producto</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Vestido</td>
                    <td><img src="img/peq/vestido.png"></td>
                    <td>34.99€</td>
                    <td><input type="number" value="0"></td>
                </tr>
                <tr>
                    <td>Cárdigan</td>
                    <td><img src="img/peq/chaqueta.png"></td>
                    <td>24.99€</td>
                    <td><input type="number" value="0"></td>
                </tr>
                <tr>
                    <td>Vestido niña</td>
                    <td><img src="img/peq/vestido2.jpg"></td>
                    <td>12.95€</td>
                    <td><input type="number" value="0"></td>
                </tr>
                <tr>
                    <td>Botines</td>
                    <td><img src="img/peq/botines.png"></td>
                    <td>49.99€</td>
                    <td><input type="number" value="0"></td>
                </tr>
                <tr>
                    <td>Collar</td>
                    <td><img src="img/collar.png"></td>
                    <td>8.99€</td>
                    <td><input type="number" value="0" size="10"></td>
                </tr>
            </tbody>
        </table>
        <input type="submit" value="Añadir al carrito"/>
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



        