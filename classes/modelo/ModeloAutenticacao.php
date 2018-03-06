<?php
class ModeloAutenticacao extends Modelo {
	
	public function entrar(string $usuario, string $senha) {
		$sql = "
			SELECT u.usuario_id, p.nome
			FROM Usuario u
			INNER JOIN Pessoa p ON p.usuario_id = u.usuario_id
			WHERE u.usuario = '$usuario' AND u.senha = '$senha'";
		$rs = $this->fetch_all($sql);
		if(empty($rs))
			throw new Exception("Usuário ou senha estão incorretos! Por favor, tente novamente.");
		$_SESSION['usuario_id'] = $rs[0]['usuario_id'];
		$_SESSION['usuario_nome'] = $rs[0]['nome'];
		return array('falhou' => false, 'mensagem' => 'Autenticação realizada com sucesso!', 'url' => APP_INDEX);
	}
	
}
?>