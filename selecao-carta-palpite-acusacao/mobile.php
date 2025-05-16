<?php 
if($jogador["npc"]){
?>
    <div style="text-align: center;">
        <?php echo exibirTexto('O NPC '.$jogador["nome"].', fez o palpite com as cartas: '); ?>            
        <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $suspeito["imagem"]; ?>" class="img-fluid"></p>	
        <p><img width="200" src="./assets/imagens/armas/<?php echo $arma["imagem"]; ?>" class="img-fluid"></p>	
        <p><img width="200" src="./assets/imagens/locais/<?php echo $local["imagem"]; ?>" class="img-fluid"></p>	
    	<?php echo montarLinkExporCarta(); ?>
	</div>
	<?php
} else {
    echo exibirTexto('Selecine cada um dos tipos de cartas!');
    ?>
    </br>
    <div class="row">
    	<form action="./index.php" method="get" id="myForm" class="col-md-6 tabela">
			<input type="hidden" name="etapa" value="<?php echo $etapa; ?>">
			<div class="form-group">
				<label for="suspeito" style="font-size: xx-large;">Suspeito</label> <select name="suspeito" id="suspeito" class="form-control form-control-lg">
            		<?php echo montarComboBoxPorLista($suspeitos); ?>
        		</select>
			</div>
			<div class="form-group">
				<label for="arma" style="font-size: xx-large;">Arma</label> 
				<select name="arma" id="arma" class="form-control form-control-lg">
					<?php echo montarComboBoxPorLista($armas); ?>
				</select>
			</div>
			<div class="form-group">
				<label for="local" style="font-size: xx-large;">Local</label> 
				<select name="local" id="local" class="form-control form-control-lg">
					<?php echo montarComboBoxPorLista($locais); ?>
				</select>
			</div>
			<div class="form-group">
				<div class="row">
				<?php 
				    echo montarLinkFormulario('Confirmar!', 'col-md-6');
				    echo montarLinkVoltar('col-md-6'); 
			    ?>
    			</div>
    		</div>
		</form>
	</div>
	<?php
	echo '</br>'.exibirTexto('Revise a sua Ficha de Palpites!', '1', 'id="texto-ficha" style="cursor:pointer"').'</br>';
	echo exibirFichaPalpites($jogador["palpites"]);
}
?>