<?php
class HTMLProduto extends HTMLPrivado {
	
	public function construir_default( ) {
		$produtos = $this->controle->modelo->buscar_todos( );
		$trs = '';
		$size = count($produtos);
		for($i = 0; $i < $size; ++$i) {
			$trs .= '
				<tr appid="'.$produtos[$i]['produto_id'].'">
					<td>'.$produtos[$i]['produto'].'</td>
					<td>'.$produtos[$i]['preco'].'</td>
					<td>'.$produtos[$i]['comissao'].'</td>
				</tr>
			';
		}
		echo '
			<div class="bg-secondary text-white mb-3 p-3"><h4>Produtos</h4></div>
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
							<thead><tr><td>Produto</td><td>Preço</td><td>Comissão</td></tr></thead>
							<tbody>'.$trs.'</tbody>
						</table>
					</div>
				</div>
			</div>
			<script>
				function adicionar( ) {
					$("main").load("/curupira/HTML/PRODUTO/ADICIONAR");
				}

				function editar( ) {
					$("main").load("/curupira/HTML/PRODUTO/EDITAR", { produto_id: $(".selecionado").attr("appid") });
				}

				function remover( ) {
					var pids = new Array;
					$(".selecionado").each(function( ) {
						pids.push($(this).attr("appid"));
					});
					$.ajax({
						url: "/curupira/JSON/PRODUTO/REMOVER",
						type: "post",
						dataType: "json",
						data: { produto_ids: pids },
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
			<div class="bg-secondary text-white mb-3 p-3"><h4>Adicionar Produto</h4></div>
			<form class="container" method="post" action="/curupira/JSON/PRODUTO/ADICIONAR">
				<div class="form-row">
					<div class="form-group col-md-12">
						<label>Produto</label>
						<input type="text" class="form-control" />
					</div>
					<div class="form-group col-md-6">
						<label>Preço</label>
						<input type="number" class="form-control" />
					</div>					
					<div class="form-group col-md-6">
						<label>Comissão</label>
						<input type="number" class="form-control" />
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

	public function editar( ) {
		$produto_id = $_POST['produto_id'];
		$produto = $this->controle->modelo->buscar_por_id($produto_id);
		echo '
			<div class="bg-secondary text-white mb-3 p-3"><h4>Editar Produto</h4></div>
			<form class="container" method="post" action="/curupira/JSON/PRODUTO/EDITAR">
				<input type="hidden" value="'.$produto['produto_id'].'" />
				<div class="form-row">
					<div class="form-group col-md-12">
						<label>Produto</label>
						<input type="text" class="form-control" value="'.$produto['produto'].'" />
					</div>
					<div class="form-group col-md-6">
						<label>Preço</label>
						<input type="number" class="form-control" value="'.$produto['preco'].'" />
					</div>					
					<div class="form-group col-md-6">
						<label>Valor da Comissão</label>
						<input type="number" class="form-control"  value="'.$produto['comissao'].'" />
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