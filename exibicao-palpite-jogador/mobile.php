<?php echo exibirTexto('As cartas selecionadas pelo Jogador Humano foram:'); ?>
    <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $suspeito["imagem"]; ?>" class="img-fluid"></p>	
    <p><img width="200" src="./assets/imagens/armas/<?php echo $arma["imagem"]; ?>" class="img-fluid"></p>	
    <p><img width="200" src="./assets/imagens/locais/<?php echo $local["imagem"]; ?>" class="img-fluid"></p>	
<?php echo montarLinkExporCarta(); ?>