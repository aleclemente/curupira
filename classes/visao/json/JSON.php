<?php
class JSON extends Visao {
	
	public function __construct(&$controle) {
		$this->controle = $controle;
	}
	
	static public function json($conteudo) {
		header('Content-Type: application/json');
		echo json_encode($conteudo);
	}
}
?>