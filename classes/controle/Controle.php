<?php

define('APP_LOGO', '<span style="color: red;">C</span>urupira');
define('APP_INDEX', '/curupira/index.php');
define('APP_ERRO_DESCONHECIDO', 'Falha desconhecida! Por favor, contacte o administrador do sistema.');

require_once('classes/modelo/Modelo.php');
require_once('classes/modelo/ModeloAutenticacao.php');
require_once('classes/modelo/ModeloUsuario.php');
require_once('classes/modelo/ModeloProduto.php');

require_once('classes/visao/Visao.php');
require_once('classes/visao/json/JSON.php');
require_once('classes/visao/json/JSONAutenticacao.php');
require_once('classes/visao/json/JSONUsuario.php');
require_once('classes/visao/json/JSONProduto.php');

require_once('classes/visao/html/HTML.php');
require_once('classes/visao/html/HTMLAutenticacao.php');
require_once('classes/visao/html/HTMLPrivado.php');
require_once('classes/visao/html/HTMLUsuario.php');
require_once('classes/visao/html/HTMLProduto.php');

class Controle {
	
	var $comando = array( );
	var $executor = null;
	var $modelo = null;
	var $visao = array('json' => null, 'html' => null);
	
	public function __construct( ) {
		session_start( );
		$this->atribuir_comando( );		
		$this->atribuir_executor( );
	}
	
	public function executar( ) {
		try {
			if(empty($_SESSION['usuario_id']))
				$this->executar_publico( );
			else $this->executar_privado( );
		}
		catch(Exception $e) {
			$this->executar_excecao($e->getMessage( ));
		}
	}
	
	private function executar_publico( ) {
		switch(array_shift($this->comando)) {
			case 'AUTENTICACAO':
			default: $this->executar_autenticacao( ); break;
		}
	}
	
	private function executar_privado( ) {
		$this->visao['html'] = new HTMLPrivado($this);		
		switch(array_shift($this->comando)) {
			case 'AUTENTICACAO': $this->executar_autenticacao( ); break;
			case 'USUARIO': $this->executar_usuario( ); break;
			case 'PRODUTO': $this->executar_produto( ); break;
			default: $this->executor->construir_default( ); break;
		}
	}
	
	private function executar_autenticacao( ) {
		$this->modelo = new ModeloAutenticacao($this);
		$this->visao['html'] = new HTMLAutenticacao($this);	
		$this->visao['json'] = new JSONAutenticacao($this);		
		switch(array_shift($this->comando)) {
			case 'ENTRAR': $this->executor->entrar( ); break;
			case 'SAIR': $this->executor->sair( ); break;
			default: $this->executor->construir_default( ); break;
		}
	}

	private function executar_usuario( ) {
		$this->modelo = new ModeloUsuario($this);
		$this->visao['html'] = new HTMLUsuario($this);	
		$this->visao['json'] = new JSONUsuario($this);		
		switch(array_shift($this->comando)) {
			case 'ADICIONAR': $this->executor->adicionar( ); break;
			case 'EDITAR': $this->executor->editar( ); break;
			case 'REMOVER': $this->executor->remover( ); break;
			default: $this->executor->construir_default( ); break;
		}
	}	

	private function executar_produto( ) {
		$this->modelo = new ModeloProduto($this);
		$this->visao['html'] = new HTMLProduto($this);	
		$this->visao['json'] = new JSONProduto($this);		
		switch(array_shift($this->comando)) {
			case 'ADICIONAR': $this->executor->adicionar( ); break;
			case 'EDITAR': $this->executor->editar( ); break;
			case 'REMOVER': $this->executor->remover( ); break;
			default: $this->executor->construir_default( ); break;
		}
	}	
	
	private function executar_excecao($mensagem) {
		$dados = array('falhou' => true, 'mensagem' => $mensagem);
		JSON::json($dados);
	}
	
	private function atribuir_comando( ) {
		if(empty($this->comando)) {
			$split = explode('?', $_SERVER['REQUEST_URI']);
			$this->comando = array_slice(explode('/', reset($split)), 2);
		}
		else $this->comando = explode('/', $this->comando);		
	}
	
	private function atribuir_executor( ) {
		switch(array_shift($this->comando)) {
			case 'JSON': $this->executor = &$this->visao['json']; break;
			case 'HTML':
			default: $this->executor = &$this->visao['html']; break;
		}
	}
}
?>