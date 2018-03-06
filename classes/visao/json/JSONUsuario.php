<?php
class JSONUsuario extends JSON {
		
	public function adicionar( ) {
		$nome = $_POST['params'][0];
		$numero_pessoa = $_POST['params'][1];
		$email = $_POST['params'][2];
		$senha = hash('sha512', $_POST['params']['3']);
		$resposta = $this->controle->modelo->adicionar($nome, $numero_pessoa, $email, $senha);
		$this->json($resposta);
	}

	public function editar( ) {
		$usuario_id = $_POST['params'][0];
		$nome = $_POST['params'][1];
		$numero_pessoa = $_POST['params'][2];
		$email = $_POST['params'][3];
		$resposta = $this->controle->modelo->editar($usuario_id, $nome, $numero_pessoa, $email);
		$this->json($resposta);
	}
	
	public function remover( ) {
		$uids = implode(',', $_POST['usuario_ids']);
		$resposta = $this->controle->modelo->remover($uids);
		$this->json($resposta);
	}	
}
?>