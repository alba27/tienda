
<?php
$tiempo=0;
$codigo="";
if (!isset($_GET['codigo'])){
	header("Location: panaderia.php");
	exit;
}
$codigo=strip_tags(trim($_GET['codigo']));
if (empty($codigo)){
	header("Location: panaderia.php");
	exit;
}
include "../../seguridad/tema04/datosBD.php";
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}
mysqli_set_charset($canal,"utf8");

$sql="select * from producto where codigo=?";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_bind_param($consulta,"i",$cod);

$cod=$codigo;

mysqli_stmt_execute($consulta);
mysqli_stmt_bind_result($consulta, $ccodigo,$nombre,$descripcion,$alta,$baja);

mysqli_stmt_store_result($consulta);
$n=mysqli_stmt_num_rows($consulta);

if ($n!=1){
	header("Location: panaderia.php");
	exit;
}
mysqli_stmt_fetch($consulta);
mysqli_stmt_close($consulta);
mysqli_close($canal);

if (!isset($_COOKIE['galleta'])){
	setcookie('galleta[0]',$codigo,$tiempo);
}else{
	$galleta=$_COOKIE['galleta'];
	$n=count($galleta);
	if (!in_array($codigo,$galleta)){
		if ($n!=3){
			setcookie("galleta[$n]",$codigo,$tiempo);
		}else{
			$galleta=array_reverse($galleta);
			array_pop($galleta);
			$galleta=array_reverse($galleta);
			array_push($galleta,$codigo);
			foreach($galleta as $indice => $valor){
				setcookie("galleta[$indice]",$valor,$tiempo);
			}
		}
	}
}
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>Panadería</title>
<style type="text/css">
body {
	font-family: verdana;
}
header {
		padding: 20px;
		font-size: 2em;
		font-weight: bold;
		background-color: red;
		color: white;
		margin-bottom: 15px;
	}
article {
	width: 70%;
	margin: 0 auto;
	text-align: justify;
	padding-top: 15px;
}
table {
	border-collapse: collapse;
}

.enlaceboton {
	text-decoration:none;
	color: white;
	border: 1px solid black;
	padding:5px;
	background-color: black;
}
span {
	font-size: 2em;
	font-weight: bold;
	border-top: 4px solid yellow;
	border-bottom: 4px solid yellow;
	padding-top: 10px;
	padding-bottom: 10px;
	margin-bottom: 10px;
}
#footer {
   position:fixed;
   left:0px;
   bottom:0px;
   height:30px;
   width:100%;
   background:#999;
   font-size: .8em;
   font-weight: bold;
   color: white;
}
.dcha {
	float:right;
}
.nada {
	font-size: .5em;
}
</style>
</head>
<body>
<header>
Panadería
</header>
<section>
<article>
<span><?=$nombre?></span>
<img src="<?=$alta?>" alt="<?=$nombre?>" style="float:right;" />
<p><?=$descripcion?></p>
</article>
<section>
<footer id="footer">
Esta web utiliza cookies propias con fin didáctico, sin otro uso. Si continúa navegando se entiende que se aceptan. <a class="enlaceboton nada" href="politica.html" target="_blank">Política de cookies</a><a href="panaderia.php" class="dcha enlaceboton">Volver</a>
</footer>
</body>
</html>