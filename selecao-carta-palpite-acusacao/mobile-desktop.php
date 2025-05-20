<?php 
function montarTelaFormularioPalpiteAcusacao($etapa, $suspeitos, $armas, $locais){
    return '<form action="./index.php" method="get" id="myForm" class="col-md-8 tabela">
    			<input type="hidden" name="etapa" value="'.$etapa.'">
    			<div class="form-group row align-items-center">
    				<label for="suspeito" style="font-size: xx-large;" class="col-md-2">
                        <img width="80" src="./assets/imagens/suspeito.png" class="img-fluid">
                    </label> 
                    <select name="suspeito" id="suspeito" class="form-control form-control-lg col-md-8">
                		'.montarComboBoxPorLista($suspeitos).'
            		</select>
    			</div>
    			<div class="form-group row align-items-center">
    				<label for="arma" style="font-size: xx-large;" class="col-md-2" >
                        <img width="80" src="./assets/imagens/arma.png" class="img-fluid">
                    </label> 
    				<select name="arma" id="arma" class="form-control form-control-lg col-md-8">
    					'.montarComboBoxPorLista($armas).'
    				</select>
    			</div>
    			<div class="form-group row align-items-center">
    				<label for="local" style="font-size: xx-large;" class="col-md-2" >
                        <img width="80" src="./assets/imagens/localizador-de-mapa.png" class="img-fluid">
                    </label> 
    				<select name="local" id="local" class="form-control form-control-lg col-md-8">
    					'.montarComboBoxPorLista($locais).'
    				</select>
    			</div>
    			<div class="form-group">
    				<div class="row">
                    '.montarLinkFormulario('Confirmar!', 'col-md-6').'
                    '.montarLinkVoltar('col-md-6').'
    				</div>
        		</div>
    		</form>';
}

function montarTelaCartasPalpiteAcusacao($jogador, $suspeito, $arma, $local, $class = 'col-md-12'){
    return '<div class="row col-md-12 justify-content-center" style="text-align: center;">
                '.exibirTexto('O NPC '.$jogador["nome"].', fez o palpite com as cartas: ').'    
                <div class="espacamentos '.$class.' "><img width="200" src="./assets/imagens/suspeitos/'.$suspeito["imagem"].'" class="img-fluid border-geral"></div>	
                <div class="espacamentos '.$class.' "><img width="200" src="./assets/imagens/armas/'.$arma["imagem"].'" class="img-fluid border-geral"></div>	
                <div class="espacamentos '.$class.' "><img width="200" src="./assets/imagens/locais/'.$local["imagem"].'" class="img-fluid border-geral"></div>	
            	'.montarLinkExporCarta().'
        	</div>';
}

function montarTelaSelecaoCartaPalpiteAcusacao($jogador, $etapa, $suspeito, $arma, $local, $suspeitos, $armas, $locais){
    if ($jogador["npc"]) {
        
        return montarTelaCartasPalpiteAcusacao($jogador, $suspeito, $arma, $local);
        
    } else {

        $html =  exibirTexto('Selecine cada um dos tipos de cartas!');
        $html .= '<div class="row espacamentos">';
        $html .= montarTelaFormularioPalpiteAcusacao($etapa, $suspeitos, $armas, $locais);
        $html .= '</div>';
        $html .= '</br>' . exibirTexto('Revise a sua Ficha de Palpites!', '1', 'id="texto-ficha" style="cursor:pointer"') . '</br>';
        $html .= exibirFichaPalpites($jogador["palpites"]);
        
        return $html;
    
    }
}

function montarTelaSelecaoCartaPalpiteAcusacaoDesktop($jogador, $etapa, $suspeito, $arma, $local, $suspeitos, $armas, $locais) {
    $texto = '';//exibirTexto('Revise a sua Ficha de Palpites!', '3', 'id="texto-ficha" style="cursor:pointer"');
    $form = '<div class="row col-md-12 justify-content-center espacamentos" >
            	<div class="col-md-9 justify-content-center espacamentos" >
                    ' . exibirTexto('Selecine cada um dos tipos de cartas!') . '
                    ' . montarTelaFormularioPalpiteAcusacao($etapa, $suspeitos, $armas, $locais) . '
            	</div>
            	<div class="col-md-3 espacamentos" >
            		' . $texto . '
                    ' . exibirFichaPalpites($jogador["palpites"]) . '
            	</div>
            </div>';

    return ($jogador["npc"]) ? montarTelaCartasPalpiteAcusacao($jogador, $suspeito, $arma, $local, 'col-md-4') : $form;
}


if ($_SESSION["layout"] == 'mobile') {
    echo montarTelaSelecaoCartaPalpiteAcusacao($jogador, $etapa, $suspeito, $arma, $local, $suspeitos, $armas, $locais);
} else {
    echo montarTelaSelecaoCartaPalpiteAcusacaoDesktop($jogador, $etapa, $suspeito, $arma, $local, $suspeitos, $armas, $locais);
}
?>