<?php
class JSONProduto extends JSON {
		
	public function adicionar( ) {
		$produto = $_POST['params'][0];
		$preco = $_POST['params'][1];
		$comissao = $_POST['params'][2];
		$resposta = $this->controle->modelo->adicionar($produto, $preco, $comissao);
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
		$pids = implode(',', $_POST['produto_ids']);
		$resposta = $this->controle->modelo->remover($pids);
		$this->json($resposta);
	}	
}
?>