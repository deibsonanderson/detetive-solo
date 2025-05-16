<?php 

echo exibirTexto('Selecione a quantidade de dados!');
echo '</br></br>';
$html = '';
for ($i = 1; $i <= 3; $i++) {
    $html .= '<div class="row">';
    $html .= '  <div class="col-md-12" style="margin-bottom:30px;">';
    $html .=      '<a href="./index.php?etapa=3&qtd_dados='.$i.'"><img width="400" src="./assets/imagens/dados/' . $i . '.png" class="img-fluid botao-dados" onclick="btnVibrate();"></a>';
    $html .= '  </div>';
    $html .= '</div>';
}
echo $html;

?>