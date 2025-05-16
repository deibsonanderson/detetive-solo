<?php
$suspeito = consultarCartaPeloCodigo($_GET["suspeito"], $CARTAS_BASE);
$arma = consultarCartaPeloCodigo($_GET["arma"], $CARTAS_BASE);
$local = consultarCartaPeloCodigo($_GET["local"], $CARTAS_BASE);

$_SESSION["palpite"] = array("suspeito" => $suspeito, "arma" => $arma, "local" => $local);

//Como ele acabou de fazer um palpite o destino dele deve mudar
foreach ($_SESSION["jogadores"] as $key => $j) {
    if($j["codigo"] == $jogador["codigo"]){
        $_SESSION["jogadores"][$key]["destinoAtual"] = carregarProximoDestino($CARTAS_BASE, $j);
        break;
    }
}
?>