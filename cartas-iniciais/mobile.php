    <?php echo exibirTexto('Selecine um destino!');  ?>
    </br>
    <div class="row">
    	<form action="./index.php" method="get" id="myForm" class="col-md-6 tabela" >
			<input type="hidden" name="etapa" value="11">
			<div class="form-group">
				<select name="local" id="local" class="form-control form-control-lg" style="font-size: xx-large;">
					<?php echo montarComboBoxPorLista($locais); ?>
				</select>
			</div>
			<div class="form-group">
    			<h1>
        			<a href="#" onclick="document.getElementById('myForm').submit(); return false;">
        				<img width="200" src="./assets/imagens/comecar.png" onclick="btnVibrate();" class="img-fluid botao-iniciar">
        			</a>
    			</h1>
			</div>
		</form>
	</div>

	<?php echo exibirTexto('Jogador anote suas cartas!');  ?>
	</br></br>
	<div class="row">
    <?php
    foreach ($jogador["cartas"] as $carta){
        $html  = '<div class="col-md-6">';
        $html .=      '<img width="400" src="./assets/imagens/'. recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]) . '" class="img-fluid">';
        $html .= '</div>';
        echo $html;
    }
    ?>        
	</div>