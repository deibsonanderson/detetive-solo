<?php 

echo exibirTexto('Selecione a quantidade de dados!');


function montarTelaSelecaoDados($class = 'col-md-12', $width = '400', $classImg = 'botao-dados') {
    $html = '<div class="row">';
    for ($i = 1; $i <= 3; $i++) {
        $html .= '  <div class=" '.$class.' justify-content-center espacamentos" style="margin-bottom:30px;">';
        $html .=      '<a href="./index.php?etapa=3&qtd_dados='.$i.'"><img width="'.$width.'" src="./assets/imagens/dados/' . $i . '.png" class="img-fluid '.$classImg.'" onclick="btnVibrate();"></a>';
        $html .= '  </div>';
    }
    $html .= '  </div>';
    return $html;
}

if ($_SESSION["layout"] == 'mobile') {
    echo montarTelaSelecaoDados();
} else {
    echo montarTelaSelecaoDados('col-md-4', '200', 'botao-dados-desktop');
}

?>