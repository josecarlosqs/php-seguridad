<?php 

class Token{
	private $expiracion;
	
	/**
	 * Constructor de la clase.
	 *
	 * El constrictor define 2 variables para realizar la validacion del token
	 * TOKEN_EXPIRADO	Cuando el token halla sobrepasado el limite de tiempo definido en el constructor.
	 * TOKEN_INCORRECTO	Cuando el token ingresado no coincida con el generado en la sesion inmediatamente anterior.
	 * TOKEN_CORRECTO 	Cuando el token este corecto, en este caso se puede continuar sin ningun problema
	 *  
	 * @param integer $tiempoExpiracion Tiempo de espiracion de los token, por default son 3 minutos
	 */
	public function Token($tiempoExpiracion=180){
		$this->expiracion = $tiempoExpiracion;
		define('TOKEN_EXPIRADO',0);
		define('TOKEN_INCORRECTO',1);
		define('TOKEN_CORRECTO',2);
	}

	/**
	 * Esta funcion devuelve el token generado para
	 * @return string
	 */
	public function generarToken(){
		@session_start();
		$nuevoToken = md5(microtime());
		$_SESSION['token'] = $nuevoToken;
		$_SESSION['token_timestamp'] = time();
		return $nuevoToken;
	}

	/**
	 * Esta funcion devuelve un array con la validez del token y, si se define en el parametro, un nuevo token
	 * @param  string   El token a validar.
	 * @param  boolean	Si se desea que la funcion genere un nuevo token despues de validar el anterior.
	 * @return Array
	 */
	public function validarToken($cadena,$regenerar = false){
		@session_start();
		$cadena = filter_var($cadena, FILTER_SANITIZE_EMAIL);
		if(time() - $_SESSION['token_timestamp'] < $this->expiracion){
			if($cadena === $_SESSION['token']){
				if($regenerar === true){
					return array("respuesta"=>TOKEN_CORRECTO,"token"=>$this->generarToken());
				}else{
					return array("respuesta"=>TOKEN_CORRECTO,"token"=>$this->generarToken());
				}
			}else{
				return array("respuesta"=>TOKEN_INCORRECTO);
			}
		}else{
			return array("respuesta"=>TOKEN_EXPIRADO);
		}

	}

}
?>
