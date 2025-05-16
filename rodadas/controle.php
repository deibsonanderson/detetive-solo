<?php
//carrega a posisão do proximo jogador na memoria
if(!$_GET["voltar"]){
    $_SESSION["posicao_jogador"] = proximaPosicaoJogador($_SESSION["posicao_jogador"], $_SESSION["jogadores"]);
}

$jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);

// Os dados que o NPC vai jogar
$totalDados = lancarDados($_SESSION["qtd_dados"]);

?>