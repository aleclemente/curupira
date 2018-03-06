<?php
class Modelo {
	var $controle = null;
	var $pdo = null;
	
	function __construct(&$controle) {
		$this->controle = $controle;
		$this->pdo['CURUPIRA'] = new PDO('mysql:host=localhost;dbname=CURUPIRA', 'curupira', '@t1r310P@uN0G@t0');
		$this->pdo["CURUPIRA"]->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);		
	}
		
	public function begin_transaction($connection = 'CURUPIRA') {
		$this->pdo[$connection]->beginTransaction( );
	}
	
	public function commit( ) {
		foreach($this->pdo as $pdo) {
			if($pdo->inTransaction( ))
				$pdo->commit( );
		}
	}
	
	public function fetch_all($sql, $params = NULL, $connection = 'CURUPIRA') {
		$stmts = $this->pdo[$connection]->prepare($sql);
		$stmts->execute($params);
		return $stmts->fetchAll(\PDO::FETCH_ASSOC);
	}
	
	public function get_last_inserted_id($connection = 'CURUPIRA') {
		return $this->pdo[$connection]->lastInsertId( );
	}
	
	public function rollback( ) {
		foreach($this->pdo as $pdo) {
			if($pdo->inTransaction( ))
				$pdo->rollback( );
		}
	}
	
	public function query($sql, $params = NULL, $connection = 'CURUPIRA') {
		if(isset($_SESSION['usuario_id']))
			$this->pdo[$connection]->query("SET @usuario_id = {$_SESSION['usuario_id']}");
		$stmts = $this->pdo[$connection]->prepare($sql);
		$stmts->execute($params);
	}
	
}
?>