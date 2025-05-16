<?php

function montarTelaSelecaoPersonagem($suspeitos, $class = 'col-md-6'){
    $html = '<div class="row justify-content-center">';
    foreach ($suspeitos as $s) {
        $html .= '<div class="'.$class.' justify-content-center">';
        $html .=      '<a href="./index.php?etapa=2&jogador=' . $s["codigo"] . '"><img width="400" src="./assets/imagens/suspeitos/' . $s["imagem"] . '" class="img-fluid" onclick="btnVibrate();"></a>';
        $html .= '</div>';
    }
    $html .= '</div>';
    return $html;
}

echo exibirTexto('Escolha o seu personagem!');

if ($_SESSION["layout"] == 'mobile') {
    echo montarTelaSelecaoPersonagem($suspeitos, 'col-md-6 espacamentos');
} else {
    echo montarTelaSelecaoPersonagem($suspeitos, 'col-md-2 espacamentos');
}
?>