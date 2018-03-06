<?php
class ModeloProduto extends Modelo {
	
	public function adicionar($produto, $preco, $comissao) {
		$this->begin_transaction( );
		$sql = "INSERT INTO Produto (produto, preco, comissao) VALUES ('$produto', $preco, $comissao)";
		$this->query($sql);
		$this->commit( );
		return array("falhou" => false, "mensagem" => "Produto adicionado com sucesso!", "url" => "/curupira/HTML/PRODUTO");
	}
	
	public function buscar_todos($modificador = null) {
		$sql = "
			SELECT produto_id, produto, preco, comissao
			FROM Produto
			$modificador
		";
		return $this->fetch_all($sql);
	}
	
	public function buscar_por_id($produto_id) {
		$rs = $this->buscar_todos("WHERE produto_id = $produto_id");
		return $rs[0];
	}
	
	public function editar($produto_id, $produto, $preco, $comissao)	 {
		$this->begin_transaction( );
		$sql = "UPDATE Produto SET produto = '$produto', preco = $preco, comissao = $comissao WHERE produto_id = $produto_id";
		$this->query($sql);
		$this->commit( );
		return array("falhou" => false, "mensagem" => "Produto editado com sucesso!", "url" => "/curupira/HTML/PRODUTO");
	}	
	
	public function remover($produto_ids) {
		$sql = "DELETE FROM Produto WHERE produto_id IN ($produto_ids)";
		$this->query($sql);
		return array("falhou" => false, "mensagem" => "Produto(s) removido(s) com sucesso!", "url" => "/curupira/HTML/PRODUTO");
	}
}
?>