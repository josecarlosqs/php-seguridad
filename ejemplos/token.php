<?php 
require_once '../Token.class.php';
$token = new Token(10);

if(isset($_GET['token'])){
	$valToken = $token->validarToken($_GET['token'],true);
	$strToken = $valToken['token'];
}else{
	$strToken = $token->generarToken();
}


 ?>
<p>
	<b>Token generado: </b><?=$strToken;?><br>
	<b>Enlace válido: </b><a href="token.php?token=<?=$strToken?>">Enlace a info clasificada</a><br>
	<b>Enlace inválido: </b><a href="token.php?token=464646token-invalido464646">Enlace a info clasificada</a>
</p>
<?php 
	if(isset($valToken)){
		if ($valToken['respuesta'] === TOKEN_CORRECTO) {
?>
	<p>Info valiosa!</p>
	<iframe width="420" height="315" src="https://www.youtube.com/embed/dRBP1rpE5y8" frameborder="0" allowfullscreen></iframe>
<?php
		}elseif ($valToken['respuesta'] === TOKEN_EXPIRADO){
?>
	<p>Tu token expiro!</p>
<?php
		}else{
?>
	<p>El token no es valido!!</p>
	<p>Vuelve a generar uno <a href="token.php">aqui</a></p>
<?php
		}
	}
?>
