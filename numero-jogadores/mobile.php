<?php
echo exibirTexto('Escolha o total de jogadores!');
echo '</br></br>';
$html = '<div class="row">';
for ($i = 1; $i < 7; $i++) {
    $html .= '<div class="row col-md-6">';
    $html .=      '<a href="./index.php?etapa=1&numero='.$i.'"><img width="400" src="./assets/imagens/numero-jogadores/' . $i . '.png" class="img-fluid botao-total-jogadores" onclick="btnVibrate();"></a>';
    $html .= '</div>';
}
$html .= '</div>';
echo $html;
?>