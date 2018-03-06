<?php
class HTMLAutenticacao extends HTML {
	
	function construir_default( ) {
		$conteudo = '
			<main>
				<div class="container">
					<div class="row">
						<div class="col"></div>
						<div class="col">
							<div class="card">
								<div class="card-body">
									<div class="card-title"><h1>'.APP_LOGO.'</h1></div>
									<form method="post" action="/curupira/JSON/AUTENTICACAO/ENTRAR">
										<div class="form-group">
											<label>Usuários</label>
											<input type="text" class="form-control" />
										</div>
										<div class="form-group">
											<label>Senha</label>
											<input type="password" class="form-control" />
										</div>
										<button type="submit" class="btn btn-primary">Confirmar</button>
									</form>
								</div>
							</div>
						</div>
						<div class="col"></div>
					</div>
				</div>
			</main>
			<script>
				$("main form").submit(function(event) {
					event.preventDefault( );
					var f = $(this);
					var usuario = f.find("input[type=text]").val( );
					var senha = f.find("input[type=password]").val( );
					travar_tela( );
					$.ajax({
						url: f.attr("action"),
						type: f.attr("method"),
						data: { usuario: usuario, senha: CryptoJS.SHA512(senha).toString( ) },
						dataType: "json",
						cache: false,
						success: function(resposta) {
							destravar_tela( );
							alert(resposta.mensagem);
							if(!resposta.falhou)
								location.href = resposta.url;
						},
						error: function(resposta) {
							destravar_tela( );
							alert("'.APP_ERRO_DESCONHECIDO.'");
						}
					});
					return false;
				});
			</script>
		';
		$this->html($conteudo);
	} 
}
?>