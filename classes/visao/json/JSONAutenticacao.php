<?php
class JSONAutenticacao extends JSON {
		
	function entrar( ) {
		$usuario = $_POST['usuario'];
		$senha = hash('sha512', $_POST['senha']);
		$resposta = $this->controle->modelo->entrar($usuario, $senha);
		$this->json($resposta);
	}
	
	public function sair( ) {
		$_SESSION = array( );
		session_destroy( );
		$resposta = array('falhou' => false, 'mensagem' => '', 'url' => APP_INDEX);
		$this->json($resposta);
		exit(0);
	}
	
}
?>