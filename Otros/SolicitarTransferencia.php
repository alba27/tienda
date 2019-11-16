<?php
$ccc1="";
if (isset($_GET['ccc1'])){
	$ccc1=strip_tags(trim($_GET['ccc1']));
}
$ccc2="";
if (isset($_GET['ccc2'])){
	$ccc2=strip_tags(trim($_GET['ccc2']));
}
$cantidad="";
if (isset($_GET['cantidad'])){
	$cantidad=strip_tags(trim($_GET['cantidad']));
}
$mensaje="";
if (isset($_GET['mensaje'])){
	$mensaje=strip_tags(trim($_GET['mensaje']));
}
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
.error {
	color: red;
	font-weight: bold;
}
</style>
</head>
<body>
<header>
Solicitar Transferencia Interna
</header>
<section>
<p><span class="error"><?=$mensaje?></span></p>
<form action="transferencia.php" method="post">
CCC origen: <input type="text" name="ccc1" value="<?=$ccc1?>" size="24" maxlength="24" /><br />
CCC destino: <input type="text" name="ccc2" value="<?=$ccc2?>" size="24" maxlength="24" /><br />
Cantidad: <input type="text" name="cantidad" value="<?=$cantidad?>" size="10" maxlength="10" /><br />
<br />
<input type="submit" value="Transferencia" />
</form>
</section>
</body>
</html>