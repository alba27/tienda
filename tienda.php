<?php

$mensaje="";
if (isset($_GET['mensaje'])){
    $mensaje=strip_tags($_GET['mensaje']);
}

/* Comprobación del usuario */
$usu="";
if(isset($_GET['usuario'])){
    $usu=strip_tags($_GET['usuario']);
}
/* Comprobación de la contraseña */
$con="";
if(isset($_GET['contrasena'])){
    $con=strip_tags($_GET['contrasena']);
}

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="css/tienda.css">
</head>

<body>
    <!-- *****  Cabecera  ***** -->
    <header>
        <img src="img/logo.png">
        <h1>R&amp;C</h1>
        <p><?=$mensaje?></p>
        <form action="compra.php" method="post">
            <label>Usuario:</label><input type="text" name="usuario" size="15" maxlength="24" value="<?=$usu?>"/>
            <label>Contraseña:</label><input type="password" name="contrasena" size="15" maxlength="24" value="<?=$con?>"/>
            <input type="submit" value="Acceder"/>
        </form>
    </header>
    <!-- *****  Contenido principal  ***** -->
    <main>
        <p>Últimas novedades</p>
        <img src="img/vestido.png" class="imagenes" id="img1"> 
        <img src="img/chaqueta.png" class="imagenes">
        <img src="img/vestido2.png" class="imagenes" id="img2">
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
    </footer>
</body>

</html>
