<?php 
if ($_SESSION["layout"] == 'mobile') {
    echo '<p><img width="400" src="./assets/imagens/'.recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]).'" class="img-fluid border-geral"></p>';
    echo exibirFichaPalpites($palpites);
    echo montarLinkProximaRodada();    
} else {
?>
	<!-- div class="row col-md-12 justify-content-center" >
    	<div class="row espacamentos col-md-4 justify-content-center" >
    		 <?php //echo '<p><img width="200" src="./assets/imagens/'.recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]).'" class="img-fluid border-geral"></p>'; ?>
		</div>
	<div class="row col-md-8 espacamentos justify-content-center">
		<?php //echo exibirFichaPalpitesHorizontal($palpites); ?>	
	</div>		
	</div>
	<div class="row col-md-12 espacamentos justify-content-center">
		<?php //echo montarLinkProximaRodada(); ?>
	</div-->
	
	
	<div class="row justify-content-center" >
    	<div class="col-md-2 justify-content-center" >
    		<div class="row col-md-12 espacamentos justify-content-center">
	    		<img width="150" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid border-geral">
    		</div>   
    		<div class="row col-md-12 espacamentos justify-content-center">
	    		<img width="100" src="./assets/imagens/<?php echo ($jogador["npc"])? 'computador.png' : 'humano.png'; ?>" class="img-fluid border-geral">
    		</div> 
		</div>
		<div class="col-md-6" >
    		<div class="row col-md-12 espacamentos justify-content-center border-geral">
    			<?php echo exibirTexto($jogador["nome"]); ?>    		
    		</div>
    		<div class="row col-md-12 espacamentos justify-content-center border-geral" style="padding-left:0px">
				<?php echo exibirTexto('Possui a cartar abaixo:', '2'); ?>    		
    		</div>    		
    		<div class="row col-md-12 justify-content-center espacamentos">
    			<div class="row col-md-6 justify-content-center">
    				<?php echo '<p><img width="200" src="./assets/imagens/'.recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]).'" class="img-fluid border-geral"></p>'; ?>
    			</div>
    			<div class="row col-md-6 justify-content-center">
    				<?php echo montarLinkProximaRodada(); ?>
    			</div>	
    		</div>    		
		</div>
		<div class="row col-md-4 justify-content-center espacamentos">
			<?php echo exibirFichaPalpites($palpites); ?>    		
		</div> 		
	</div>	
<?php     
}
?>