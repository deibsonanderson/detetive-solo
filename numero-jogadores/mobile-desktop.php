<?php

function montarTelaTotalJogadores($html, $classDiv = 'col-md-6', $width = '400', $classImg = 'botao-geral'){
    for ($i = 1; $i < 7; $i ++) {
        $texto = '<span></br>'.$i.' Jogadores</span>';
        $html .= '<div class="row ' . $classDiv . ' justify-content-center">';
        $html .= '<a href="./index.php?etapa=1&numero=' . $i . '" style="text-decoration: none;color:black;"><img width="400" src="./assets/imagens/numero-jogadores/' . $i . '.png" class="img-fluid ' . $classImg . '" onclick="btnVibrate();">'.$texto.'</a>';
        $html .= '</div>';
    }
    return $html;
}

echo exibirTexto('Escolha o total de jogadores!');
echo '</br></br>';
$html = '<div class="row justify-content-center">';
if ($_SESSION["layout"] == 'mobile') {
    $html .= montarTelaTotalJogadores($html, 'col-md-6', '400', 'botao-total-jogadores');
} else {
    $html .= montarTelaTotalJogadores($html, 'col-md-3', '400', 'botao-geral-desktop');
}
$html .= '</div>';
echo $html;
?>