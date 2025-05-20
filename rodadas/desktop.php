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
    			<h3><?php echo $jogador["nome"].'.'; ?></h3>    		
    		</div>
    		<div class="row espacamentos">
    			<div class="row col-md-9 espacamentos">
    				<?php echo montarExibicaoConometro('6', 'digital-clock-desktop', '53'); ?>
    			</div>
    			<div class="row col-md-3 espacamentos justify-content-center">
    				<img width="50" src="./assets/imagens/pinus/<?php echo $jogador["pinu"]; ?>.png" class="img-fluid">
    			</div>  	
    		</div>
    		<div class="row col-md-12 espacamentos border-geral">
  				<h3>Movimente <span id="dados-numero" style="display: none; font-size: larger; color: RED;"><?php echo $totalDados; ?></span> casas!</h3>
    		</div>
    		<div class="row col-md-12 border-geral" style="padding-left:0px">
				<div class="col-md-9" style="align-self: anchor-center; text-align: left;" >
					<?php echo exibirTexto('Próximo destino:', '2'); ?>
				</div>
				<div class="col-md-3" >
					<img width="100" src="./assets/imagens/locais/<?php echo $jogador["destinoAtual"]["imagem"]; ?>" class="img-fluid espacamentos border-geral">    					
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
    		<div class="espacamentos">
        	<?php
            	if (!$jogador["npc"]) {
        		  //echo exibirTexto('Revise a sua Ficha de Palpites!', 'id="texto-ficha" style="cursor:pointer" ');
        		  echo exibirFichaPalpites($jogador["palpites"]);
            	}
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
              <?php 
              if($_SESSION["tempo"] != null && $_SESSION["tempo"] > 0 ){
                  echo 'second = '.$_SESSION["tempo"];   
              }
              ?>
              
              
              cronometroStart(null, '53');
            }, 1500);
		}); 
	</script>