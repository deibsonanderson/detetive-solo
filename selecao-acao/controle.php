<?php
//o jogador é listado para ser exibido
$jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);

//controla se NPC vai ou não realizar acusacao
$total = 0;
foreach ($jogador["palpites"] as $chave => $palpite) {
    foreach ($palpite as $carta) {
        if ($carta["marcado"] == 0) {
            $total ++;
        }
    }
}
?>