<?php 
function montarTelaFormularioDestinoInicial($locais, $class = 'col-md-6', $opcional = '') {
    return '<form action="./index.php" method="get" id="myForm" class="'.$class.' tabela" '.$opcional.' >
    			<input type="hidden" name="etapa" value="11">
    			<div class="form-group">
    				<select name="local" id="local" class="form-control form-control-lg" style="font-size: xx-large;">
    					'.montarComboBoxPorLista($locais).'
    				</select>
    			</div>
    			<div class="form-group">
        			<h1>
            			<a href="#" onclick="document.getElementById(\'myForm\').submit(); return false;">
            				<img width="200" src="./assets/imagens/comecar.png" onclick="btnVibrate();" class="img-fluid botao-iniciar">
            			</a>
        			</h1>
    			</div>
    	   </form>';
}

function montarTelaCartasDistribuidas($jogador, $class = 'col-md-6'){
    $html = '<div class="row espacamentos justify-content-center">';
    foreach ($jogador["cartas"] as $carta){
        $html .= '<div class="'.$class.' justify-content-center espacamentos">';
        $html .=      '<img width="400" src="./assets/imagens/'. recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]) . '" class="img-fluid">';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}

$tituloForm = 'Selecine seu destino inicial';
$tituloCartas = 'Jogador anote suas cartas!';

if ($_SESSION["layout"] == 'mobile') {
    echo exibirTexto($tituloForm);
    echo '<div class="row espacamentos">';
    echo montarTelaFormularioDestinoInicial($locais);
    echo '</div>';
    echo exibirTexto($tituloCartas);
    echo montarTelaCartasDistribuidas($jogador);
} else {
    ?>
    <div class="row espacamentos">
        <div class="col-md-4 justify-content-center ">
        	<?php 
        	   echo exibirTexto($tituloForm, '2');  
               echo montarTelaFormularioDestinoInicial($locais, 'col-md-12'); 
        	?>
        </div>
        <div class="row col-md-8 justify-content-center ">
        	<?php 
        	   echo exibirTexto($tituloCartas); 
               echo montarTelaCartasDistribuidas($jogador, 'col-md-2'); 
        	?>
        </div>    
    </div>    
    <?php 
}
?>