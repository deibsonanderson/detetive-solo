	<div class="row justify-content-center" >
    	<div class="col-md-2 justify-content-center" >
    		<div class="row col-md-12 espacamentos">
	    		<img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid border-geral">
    		</div>   
    		<div class="row col-md-12 espacamentos">
	    		<img width="150" src="./assets/imagens/<?php echo ($jogador["npc"])? 'computador.png' : 'humano.png'; ?>" class="img-fluid border-geral">
    		</div>   		
		</div>
		<div class="col-md-6" >
    		<div class="row col-md-12 espacamentos border-geral">
    			<h1><?php echo $jogador["nome"].'.'; ?></h1>    		
    		</div>
    		<div class="row espacamentos">
  				<?php echo montarExibicaoConometro(); ?>
    		</div>
    		<div class="row col-md-12 espacamentos border-geral">
  				<h1>Movimente <span id="dados-numero" style="display: none; font-size: larger; color: RED;"><?php echo $totalDados; ?></span> casas!</h1>
    		</div>
    		<div class="row col-md-12 espacamentos border-geral" style="padding-left:0px">
				<div class="col-md-9" style="align-self: anchor-center; text-align: left;" >
					<?php echo exibirTexto('Próximo destino:'); ?>
				</div>
				<div class="col-md-3" >
					<img width="200" src="./assets/imagens/locais/<?php echo $jogador["destinoAtual"]["imagem"]; ?>" class="img-fluid espacamentos">    					
				</div>
    		</div>    		
    		<div class="row col-md-12 justify-content-center espacamentos">
    			<?php
        		  $html = '<div class="row">';
        		  if ($jogador["npc"]) {
        		      $html .= montarLinkProximaRodada('col-md-6');
        		      $html .= montarLinkChegueiLocal('col-md-6');
        		  } else {
        		      $html .= montarLinkProximaRodada('col-md-4');
        		      $html .= montarLinkChegueiLocal('col-md-4');
        		      $html .= montarLinkAtualizarDestino('col-md-4');
        		  }
        		  echo $html.'</div>';
            	?>
    		</div> 
		</div>
		<div class="col-md-4" >
    		<div class="espacamentos" >
        	<?php
    		  //echo exibirTexto('Revise a sua Ficha de Palpites!', 'id="texto-ficha" style="cursor:pointer" ');
    		  echo exibirFichaPalpites($jogador["palpites"]);
    		?>
    		</div>  
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
        	$('#jogar-dados').show();
        	setTimeout(function() {
              $('#jogar-dados').fadeOut('slow');
              $('#dados-numero').fadeIn('slow');
              cronometroStart();
            }, 1500);
		}); 
	</script>