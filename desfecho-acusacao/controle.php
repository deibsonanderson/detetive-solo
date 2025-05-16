<?php 
$suspeito = $_SESSION["criminoso"]["suspeito"];
$arma = $_SESSION["criminoso"]["arma"];
$local = $_SESSION["criminoso"]["local"];

$sucesso = ($suspeito["codigo"] == $_GET["suspeito"] && $arma["codigo"] == $_GET["arma"] && $local["codigo"] == $_GET["local"]);
$jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);

if($jogador["npc"] && !$sucesso){
    //Esse fluxo é reponsavel por reorganizar a posição do proximo jogador
    $_SESSION["jogadores"] = removerJogador($_SESSION["jogadores"], $jogador);
    if ($_SESSION["posicao_jogador"] < count($_SESSION["jogadores"])) {
        $_SESSION["posicao_jogador"] = retornarPosicaoJogador($_SESSION["posicao_jogador"], $_SESSION["jogadores"]);
    }
}
?>