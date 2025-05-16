<p><h1><?php echo $jogador["nome"].'.'; ?></h1></p>
<p><img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid"></p>
<?php
echo '<div class="row">';
if ($jogador["npc"]) {

    echo ($total == 0) ? montarLinkRealizarPalpiteAcusacao(true,'col-md-6') : montarLinkRealizarPalpiteAcusacao(false, 'col-md-6');
    echo montarLinkVoltar('col-md-6');
    echo '</div>';

} else {

    echo montarLinkRealizarPalpiteAcusacao(false, 'col-md-4');
    echo montarLinkRealizarPalpiteAcusacao(true, 'col-md-4');
    echo montarLinkVoltar('col-md-4');
    echo '</div>';
    echo '</br>'.exibirTexto('Revise a sua Ficha de Palpites!', 'id="texto-ficha"').'</br>';
    echo exibirFichaPalpites($jogador["palpites"]);
}

?>