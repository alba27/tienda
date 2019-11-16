<?php

$mensaje="";
if (isset($_GET['mensaje'])){
    $mensaje=strip_tags(trim($_GET['mensaje']));
}

/* Comprobación del usuario */
$usu="";
if(isset($_GET['usu'])){
    $usu=strip_tags(trim($_GET['usu']));
}
/* Comprobación de la contraseña */
$con="";
if(isset($_GET['con'])){
    $con=strip_tags(trim($_GET['con']));
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
            <label>Usuario:</label><input type="text" name="usu" size="15" maxlength="24" value="<?=$usu?>"/>
            <label>Contraseña:</label><input type="password" name="con" size="15" maxlength="24" value="<?=$con?>"/>
            <input type="submit" value="Acceder"/>
        </form>
    </header>
    <!-- *****  Contenido principal  ***** -->
    <main>
        <p>Últimas novedades</p>
        <img src="img/grandes/vestido.png" class="imagenes" id="img1"> 
        <img src="img/grandes/chaqueta.png" class="imagenes">
        <img src="img/grandes/vestido2.png" class="imagenes" id="img2">
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
