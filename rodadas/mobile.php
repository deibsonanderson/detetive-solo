	<p><h1><?php echo $jogador["nome"].'.'; ?></h1></p>	
	<p><img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid"></p>
	<p><h1><img width="80" src="./assets/imagens/<?php echo ($jogador["npc"])? 'computador.png' : 'humano.png'; ?>" class="img-fluid"></h1></p>
	<p><h1>Movimente <span id="dados-numero" style="display: none; font-size: larger; color: RED;"><?php echo $totalDados; ?></span> casas!</h1></p>
	<p><?php echo exibirTexto('Seu destino atual é: '.$jogador["destinoAtual"]["nome"]).'</br>'; ?></p>
	
	<?php echo montarExibicaoConometro(); ?>
	
		<?php
		  $html = '<div class="row ">';
		  if ($jogador["npc"]) {
		      $html .= montarLinkProximaRodada('col-md-6');
		      $html .= montarLinkChegueiLocal('col-md-6');
		      echo $html.'</div>';
		  } else {
		      $html .= montarLinkProximaRodada('col-md-4');
		      $html .= montarLinkChegueiLocal('col-md-4');
		      $html .= montarLinkAtualizarDestino('col-md-4');
		      echo $html.'</div>';
		      
		      echo '</br>'.exibirTexto('Revise a sua Ficha de Palpites!','1' ,'id="texto-ficha" style="cursor:pointer"').'</br>';
		      echo exibirFichaPalpites($jogador["palpites"]);
		  }	
		  
	?>
	
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