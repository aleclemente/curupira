<?php
class HTML extends Visao {
	
	function __construct(&$controle) {
		$this->controle = $controle;
	}
	
	function html($conteudo) {
		header('Content-Type: text/html');
		echo '
			<!doctype html>
			<html lang="pt-br">
			<head>
				<meta charset="utf-8">
				<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
				<title>Curupira</title>
				<link rel="icon" href="/curupira/share/imagens/curupira.jpg">
				<link rel="stylesheet" href="/curupira/share/bootstrap-4.0.0-dist/css/bootstrap.min.css">
				<script src="/curupira/share/jquery/jquery-3.3.1.min.js"></script>
				<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" crossorigin="anonymous"></script>
				<script src="/curupira/share/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>				
				<script src="/curupira/share/cryptojs/rollups/sha512.js"></script>
				<script>
					function travar_tela( ) {
						$(".overlay").removeClass("d-none");
					}
					
					function destravar_tela( ) {
						$(".overlay").addClass("d-none");
					}
				</script>
				<style>
					.overlay {
						background-color: rgba(255, 255, 255, 0.85);
						height: 100%;
						left: 0;
						position: fixed;
						top: 0;
						width: 100%;
						z-index: 10;
					}

					.overlay > .loader {
						display: block;
						margin: auto;
						opacity: 0.25;
						width: 50%;
					}				
				
					.selecionado * {
						background-color: #007bff;
						color: #fff;
					}
				</style>
			</head>
			<body>
				<div class="d-none overlay">
					<img class="loader" src="/curupira/share/images/loader.gif" />
				</div>			
				'.$conteudo.'
			</body>
			</html>
		';
	} 
}
?>