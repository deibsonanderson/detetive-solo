<?php
//carrega a posisão do proximo jogador na memoria
if(!$_GET["voltar"]){
    $_SESSION["posicao_jogador"] = proximaPosicaoJogador($_SESSION["posicao_jogador"], $_SESSION["jogadores"]);
}

$jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);

// Os dados que o NPC vai jogar
$totalDados = lancarDados($_SESSION["qtd_dados"]);

// esse bloco tem a função de sobescrever a variavel presente no cronometro.js
$second = ' ';
if($_SESSION["tempo"] != null && $_SESSION["tempo"] > 0 ){
    $second = 'second = '.$_SESSION["tempo"].';';
}

?>