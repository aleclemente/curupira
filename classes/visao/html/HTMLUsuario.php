<?php
class HTMLUsuario extends HTMLPrivado {
	
	public function construir_default( ) {
		$usuarios = $this->controle->modelo->buscar_todos( );
		$trs = '';
		$size = count($usuarios);
		for($i = 0; $i < $size; ++$i) {
			$trs .= '
				<tr appid="'.$usuarios[$i]['usuario_id'].'">
					<td>'.$usuarios[$i]['nome'].'</td>
					<td>'.$usuarios[$i]['usuario'].'</td>
					<td>'.$usuarios[$i]['numero_pessoa'].'</td>
				</tr>
			';
		}
		echo '
			<div class="bg-secondary text-white mb-3 p-3"><h4>Usuários</h4></div>
			<div class="container">
				<div class="row">
					<div class="col">
						<br />
						<div class="btn-toolbar" role="toolbar">
							<div class="btn-group mr-2" role="group">
								<button type="button" class="btn btn-primary" appcmd="ADICIONAR">Adicionar</button>
								<button type="button" class="btn btn-primary" appcmd="EDITAR">Editar</button>
								<button type="button" class="btn btn-danger" appcmd="REMOVER">Remover</button>
							</div>
						</div>
						<br />
						<table class="table table-striped table-hover">
							<thead><tr><td>Nome</td><td>Usuário</td><td>CPF</td></tr></thead>
							<tbody>'.$trs.'</tbody>
						</table>
					</div>
				</div>
			</div>
			<script>
				function adicionar( ) {
					$("main").load("/curupira/HTML/USUARIO/ADICIONAR");
				}

				function editar( ) {
					$("main").load("/curupira/HTML/USUARIO/EDITAR", { usuario_id: $(".selecionado").attr("appid") });
				}

				function remover( ) {
					var uids = new Array;
					$(".selecionado").each(function( ) {
						uids.push($(this).attr("appid"));
					});
					$.ajax({
						url: "/curupira/JSON/USUARIO/REMOVER",
						type: "post",
						dataType: "json",
						data: { usuario_ids: uids },
						success: function(resposta) {
							destravar_tela( );
							alert(resposta.mensagem);
							if(!resposta.falhou)
								$("main").load(resposta.url);							
						},
						error: function(resposta) {
							destravar_tela( );
							alert("'.APP_ERRO_DESCONHECIDO.'");
						}
					});
				}
				
				$("main table tbody tr").click(function( ) {
					$(".selecionado").removeClass("selecionado");
					$(this).addClass("selecionado");
				});
				
				$("main .btn").click(function( ) {
					var comando = $(this).attr("appcmd");
					switch(comando) {
						case "ADICIONAR": adicionar( ); break;
						case "EDITAR": editar( ); break;
						case "REMOVER": remover( ); break;
					}
				});
			</script>
		';
	}
	
	public function adicionar( ) {
		echo '
			<div class="bg-secondary text-white mb-3 p-3"><h4>Adicionar Usuário</h4></div>
			<form class="container" method="post" action="/curupira/JSON/USUARIO/ADICIONAR">
				<div class="form-row">
					<div class="form-group col-md-9">
						<label>Nome</label>
						<input type="text" class="form-control" />
					</div>
					<div class="form-group col-md-3">
						<label>CPF</label>
						<input type="text" class="form-control" />
					</div>					
					<div class="form-group col-md-6">
						<label>E-mail</label>
						<input type="email" class="form-control" />
					</div>					
					<div class="form-group col-md-6">
						<label>Senha</label>
						<input type="password" class="form-control" />
					</div>					
				</div>
				<button type="submit" class="btn btn-primary">Confirmar</button>
				<button type="reset" class="btn btn-secondary">Limpar</button>
			</form>
			<script>
				$("main form").submit(function(event) {
					event.preventDefault( );
					var f = $(this);				
					var dados = new Array;
					f.find("input").each(function( ) {
						dados.push($(this).val( ));
					});
					dados[3] = CryptoJS.SHA512(dados[3]).toString( );
					travar_tela( );
					$.ajax({
						url: f.attr("action"),
						type: f.attr("method"),
						data: { params: dados },
						dataType: "json",
						cache: false,
						success: function(resposta) {
							destravar_tela( );
							alert(resposta.mensagem);
							if(!resposta.falhou)
								$("main").load(resposta.url);
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
	}

	public function editar( ) {
		$usuario_id = $_POST['usuario_id'];
		$usuario = $this->controle->modelo->buscar_por_id($usuario_id);
		echo '
			<div class="bg-secondary text-white mb-3 p-3"><h4>Editar Usuário</h4></div>
			<form class="container" method="post" action="/curupira/JSON/USUARIO/EDITAR">
				<input type="hidden" value="'.$usuario['usuario_id'].'" />
				<div class="form-row">
					<div class="form-group col-md-9">
						<label>Nome</label>
						<input type="text" class="form-control" value="'.$usuario['nome'].'" />
					</div>
					<div class="form-group col-md-3">
						<label>CPF</label>
						<input type="text" class="form-control" value="'.$usuario['numero_pessoa'].'" />
					</div>					
					<div class="form-group col-md-12">
						<label>E-mail</label>
						<input type="email" class="form-control"  value="'.$usuario['email'].'" />
					</div>								
				</div>
				<button type="submit" class="btn btn-primary">Confirmar</button>
				<button type="reset" class="btn btn-secondary">Limpar</button>
			</form>	
			<script>
				$("main form").submit(function(event) {
					event.preventDefault( );
					var f = $(this);				
					var dados = new Array;
					f.find("input").each(function( ) { 
						dados.push($(this).val( ));
					});
					travar_tela( );
					$.ajax({
						url: f.attr("action"),
						type: f.attr("method"),
						data: { params: dados },
						dataType: "json",
						cache: false,
						success: function(resposta) {
							destravar_tela( );
							alert(resposta.mensagem);
							if(!resposta.falhou)
								$("main").load(resposta.url);
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
	}	
	
}
?>