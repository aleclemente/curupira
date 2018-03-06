<?php
class HTMLPrivado extends HTML {
	
	function construir_default( ) {
		$conteudo = '
			<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
				<a class="navbar-brand" href="#">'.APP_LOGO.'</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active"> 
							<a class="nav-link" href="#" appcmd="VENDAS">Vendas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#" appcmd="CONTAS">Contas</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#" appcmd="PRODUTOS">Produtos</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="#" appcmd="USUARIOS">Usuários</a>
						</li>						
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								'.$_SESSION['usuario_nome'].'
							</a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="#" appcmd="ALTERAR_DADOS">Alterar Dados</a>
								<a class="dropdown-item" href="#" appcmd="ALTERAR_SENHA">Alterar Senha</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#" appcmd="SAIR">Sair</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>
			<main>
				<div class="container">
					<div class="row">
						<div class="col">
						</div>
					</div>
				</div>
			</main>
			<script>
				function usuarios( ) {
					$("main").load("/curupira/HTML/USUARIO");
				}
				
				function produtos( ) {
					$("main").load("/curupira/HTML/PRODUTO");
				}
			
				function sair( ) {
					travar_tela( );
					$.ajax({
						url: "/curupira/JSON/AUTENTICACAO/SAIR",
						success: function(resposta) {
							destravar_tela( );
							location.href = resposta.url;
						},
						error: function(resposta) {
							destravar_tela( );
							alert("'.APP_ERRO_DESCONHECIDO.'");
						}
					});
				}
			
				$("nav .nav-link, nav .dropdown-item").click(function( ) {
					var comando = $(this).attr("appcmd");
					switch(comando) {
						case "USUARIOS": usuarios( ); break;
						case "PRODUTOS": produtos( ); break;
						case "SAIR": sair( ); break;
					}
				});
			</script>
		';
		$this->html($conteudo);
	} 
}
?>