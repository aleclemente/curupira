<?php
class ModeloUsuario extends Modelo {
	
	public function adicionar($nome, $numero_pessoa, $email, $senha) {
		$this->begin_transaction( );
		$sql = "INSERT INTO Usuario (usuario, senha) VALUES ('$email', '$senha')";
		$this->query($sql);
		$usuario_id = $this->get_last_inserted_id( );
		$sql = "INSERT INTO Pessoa (nome, email, numero_pessoa, usuario_id) VALUES ('$nome', '$email', '$numero_pessoa', $usuario_id)";
		$this->query($sql);
		$this->commit( );
		return array("falhou" => false, "mensagem" => "Usuário adicionado com sucesso!", "url" => "/curupira/HTML/USUARIO");
	}
	
	public function buscar_todos($modificador = null) {
		$sql = "
			SELECT u.usuario_id, u.usuario, p.nome, p.numero_pessoa, p.email
			FROM Usuario u
			INNER JOIN Pessoa p ON p.usuario_id = u.usuario_id
			WHERE u.usuario_id > 1 $modificador
		";
		return $this->fetch_all($sql);
	}
	
	public function buscar_por_id($usuario_id) {
		$rs = $this->buscar_todos("AND u.usuario_id = $usuario_id");
		return $rs[0];
	}
	
	public function editar($usuario_id, $nome, $numero_pessoa, $email)	 {
		$this->begin_transaction( );
		$sql = "UPDATE Usuario SET usuario = '$email' WHERE usuario_id = $usuario_id";
		$this->query($sql);
		$sql = "UPDATE Pessoa SET nome = '$nome', email = '$email', numero_pessoa = '$numero_pessoa' WHERE usuario_id = $usuario_id";
		$this->query($sql);
		$this->commit( );
		return array("falhou" => false, "mensagem" => "Usuário editado com sucesso!", "url" => "/curupira/HTML/USUARIO");
	}	
	
	public function remover($usuario_ids) {
		$sql = "DELETE FROM Usuario WHERE usuario_id IN ($usuario_ids)";
		$this->query($sql);
		return array("falhou" => false, "mensagem" => "Usuário(s) removido(s) com sucesso!", "url" => "/curupira/HTML/USUARIO");
	}
}
?>