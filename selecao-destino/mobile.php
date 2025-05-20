<?php  echo exibirTexto('Selecine seu proximo destino!'); ?>
</br>
<div class="row">
	<form action="./index.php" id="myForm" method="get" class="col-md-6 tabela" >
		<input type="hidden" name="etapa" value="11">
		<input type="hidden" name="voltar" value="true">
		<div class="form-group row align-items-center">
			<label for="local" style="font-size: xx-large;" class="col-md-2">
                <img width="80" src="./assets/imagens/localizador-de-mapa.png" class="img-fluid">
            </label> 
            <select name="local" id="local" class="form-control form-control-lg col-md-10">
        		<?php echo montarComboBoxPorLista($locais); ?>
    		</select>
		</div>   		
		<div class="row">
		<?php 
		    echo montarLinkFormulario('Confirmar!', 'col-md-6');
		    echo montarLinkVoltar('col-md-6'); 
	    ?>
		</div>
	</form>
</div>