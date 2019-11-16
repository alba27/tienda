<?php
$datosCorrectos=true;

$ccc1="";
if (isset($_POST['ccc1'])){
	$ccc1=strip_tags(trim($_POST['ccc1']));
}
if (strlen($ccc1)!=24){
	$datosCorrectos=false;
}

$ccc2="";
if (isset($_POST['ccc2'])){
	$ccc2=strip_tags(trim($_POST['ccc2']));
}
if (strlen($ccc2)!=24){
	$datosCorrectos=false;
}

$cantidad="";
if (isset($_POST['cantidad'])){
	$cantidad=strip_tags(trim($_POST['cantidad']));
}
if (empty($cantidad) || !is_numeric($cantidad) || $cantidad<0){
	$datosCorrectos=false;
}

if (!$datosCorrectos){
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Algún valor no es correcto");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}
include "../../seguridad/tema03/datosBD.php";
$canal=@mysqli_connect(IP,USUARIO,CLAVE,BD);
if (!$canal){
	echo "Ha ocurrido el error: ".mysqli_connect_errno()." ".mysqli_connect_error()."<br />";
	exit;
}
mysqli_set_charset($canal,"utf8");

mysqli_autocommit($canal, false);

$sql="select cu.ccc, sum(m.cantidad) from cuentas cu, movimientos m where cu.ccc=m.ccc and cu.ccc=? for update";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_bind_param($consulta,"s",$cuentacorr);

$cuentacorr=$ccc1;

mysqli_stmt_execute($consulta);
mysqli_stmt_bind_result($consulta, $cccOrigen,$saldoTotal);

mysqli_stmt_store_result($consulta);
$n=mysqli_stmt_num_rows($consulta);


if ($n==0){
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Cuenta origen no existente");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}
mysqli_stmt_fetch($consulta);
if ($cantidad>$saldoTotal){
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Cantidad superior al saldo");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}
mysqli_stmt_free_result($consulta);
unset($consulta);
//---- Este código sobraría
$sql="select ccc from cuentas where ccc=? for update";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_bind_param($consulta,"s",$cuentacorr);

$cuentacorr=$ccc2;

mysqli_stmt_execute($consulta);
mysqli_stmt_bind_result($consulta, $cccDestino);

mysqli_stmt_store_result($consulta);
$n=mysqli_stmt_num_rows($consulta);
if ($n==0){
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Cuenta Destino no existente");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}
mysqli_stmt_free_result($consulta);
unset($consulta);
//--------------------
$sql="insert into movimientos (cantidad, fecha, ccc) values (?,curdate(),?)";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_bind_param($consulta,"ds",$traspaso,$cuentacorr);

$traspaso=$cantidad;
$cuentacorr=$ccc2;

if (!mysqli_stmt_execute($consulta)){
	mysqli_rollback($canal);
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Error al ingresar la cantidad en destino");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}

mysqli_stmt_free_result($consulta);
unset($consulta);

$sql="insert into movimientos (cantidad, fecha, ccc) values (?,curdate(),?)";
$consulta=mysqli_prepare($canal,$sql);
if (!$consulta){
	mysqli_rollback($canal);
	echo "Ha ocurrido el error: ".mysqli_errno($canal)." ".mysqli_error($canal)."<br />";
	exit;
}
mysqli_stmt_bind_param($consulta,"ds",$traspaso,$cuentacorr);

$traspaso=-$cantidad;
$cuentacorr=$ccc1;

if (!mysqli_stmt_execute($consulta)){
	mysqli_rollback($canal);
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Error al descontar la cantidad en origen");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}
if (!mysqli_commit($canal)){
	$http="Location: solicitarTransferencia.php?mensaje=".urlencode("Error en la operación");
	$http.="&ccc1=".urlencode($ccc1)."&ccc2=".urlencode($ccc2)."&cantidad=".urlencode($cantidad);
	header($http);
	exit;
}
mysqli_stmt_close($consulta);
mysqli_close($canal);
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8" />
<title>Solicitar Transferencia Interna</title>
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
form {
	text-align: right;
}
</style>
</head>
<body>
<header>
Transferencia
</header>
<section>
Cuenta Origen: <?=$ccc1?><br /> Cuenta Destino: <?=$ccc2?> <p>Transferencia EFECTUADA: <?=$cantidad?></p>
</section>
</body>
</html>