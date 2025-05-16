<?php 
echo '<p><img width="400" src="./assets/imagens/'.recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]).'" class="img-fluid"></p>';
echo exibirFichaPalpites($palpites); 
echo montarLinkProximaRodada();
?>