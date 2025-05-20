<?php 
function montarTelaExporCartasPalpiteAcusacaoHumano($suspeito, $arma, $local, $class = 'col-md-12'){
    return '<div class="row col-md-12 justify-content-center" style="text-align: center;">
                '.exibirTexto('As cartas selecionadas pelo Jogador Humano foram:').'
                <div class="espacamentos '.$class.' "><img width="200" src="./assets/imagens/suspeitos/'.$suspeito["imagem"].'" class="img-fluid border-geral"></div>
                <div class="espacamentos '.$class.' "><img width="200" src="./assets/imagens/armas/'.$arma["imagem"].'" class="img-fluid border-geral"></div>
                <div class="espacamentos '.$class.' "><img width="200" src="./assets/imagens/locais/'.$local["imagem"].'" class="img-fluid border-geral"></div>

        	</div>
            <div class="row justify-content-center">
                <div class="row">
                	'.montarLinkExporCarta('col-md-6 espacamentos').'
                    '.montarLinkVoltar('col-md-6 espacamentos', '6').'            
                </div>
            </div>
';
}

if ($_SESSION["layout"] == 'mobile') {
    echo montarTelaExporCartasPalpiteAcusacaoHumano($suspeito, $arma, $local);
} else {
    echo montarTelaExporCartasPalpiteAcusacaoHumano($suspeito, $arma, $local, 'col-md-4');
}

?>
