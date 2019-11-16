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
	width: 40%;
	margin: 0 auto;
}
table {
	border-collapse: collapse;
}
tr:nth-child(even){
	background-color: #cacaca;
}
th {
	background-color: green;
	color: white;
}
th, td {
	padding: 10px;
}
.arriba {
	border-top: 1px solid black;
}
.enlaceboton {
	text-decoration:none;
	color: white;
	border: 1px solid black;
	padding:5px;
	background-color: black;
}
.enlace {
	border: 3px solid black;
	margin-right: 5px;
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
<?php
include "../../seguridad/tema04/datosBD.php";
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}
mysqli_set_charset($canal,"utf8");

$sql="select codigo,nombre,baja from producto order by nombre";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_execute($consulta);
mysqli_stmt_bind_result($consulta,$codigo,$nombre,$baja);
?>
<article>
	<table>
	<tr>
	<th>NOMBRE</th><th>IMAGEN</th><th></th>
	</tr>
<?php
	while(mysqli_stmt_fetch($consulta)){
		echo "<tr>";
		echo "<td>$nombre</td><td><img src='".$baja."' alt='".$nombre."' /></td><td><a href='ver.php?codigo=".$codigo."' class='enlaceboton' >Ver producto</a></td>";
		echo "</tr>";
	}
	mysqli_stmt_close($consulta);
	unset($consulta);
?>
	</table>
</article>
<article>
<?php
if (isset($_COOKIE['galleta'])){
	echo "<p></p><p style='font-size: 0.5em; font-weight: bold;'>Últimos productos visitados</p>";
	$cadenaGalleta=implode(",",$_COOKIE['galleta']);
	$sql="select codigo,nombre,baja from producto where codigo in (".$cadenaGalleta.")";
	$consulta=mysqli_prepare($canal,$sql);
	if (!$consulta){
		echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
		exit;
	}
	mysqli_stmt_execute($consulta);
	mysqli_stmt_bind_result($consulta,$ccodigo,$nombre,$baja);
	while(mysqli_stmt_fetch($consulta)){
		echo "<a href='ver.php?codigo=".$ccodigo."' ><img src='".$baja."' alt='".$nombre."' height='67' width='100' class='enlace'/></a>";
	}	
	mysqli_stmt_close($consulta);
}
?>
<p>&nbsp;</p>
</article>
<?php

mysqli_close($canal);
?>
<section>
<footer id="footer">
Esta web utiliza cookies propias con fin didáctico, sin otro uso. Si continúa navegando se entiende que se aceptan. <a class="enlaceboton nada" href="politica.html" target="_blank">Política de cookies</a>
</footer>
</body>
</html>