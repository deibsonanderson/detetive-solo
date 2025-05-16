<?php
echo exibirTexto('Escolha o seu personagem!');
echo '</br></br>';
$html = '<div class="row">';
foreach ($suspeitos as $s) {
    $html .= '<div class="col-md-6">';
    $html .= '<a href="./index.php?etapa=2&jogador='.$s["codigo"].'"><img width="400" src="./assets/imagens/suspeitos/' . $s["imagem"] . '" class="img-fluid" onclick="btnVibrate();"></a>';
    $html .= '</div>';
}
$html .= '</div>';
echo $html;
?>