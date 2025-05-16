<?php
unset($_SESSION["numero_participante"]);
unset($_SESSION["jogador"]);

$_SESSION["qtd_dados"] = $_GET["qtd_dados"];
$jogador = retornarJogadorHumano($_SESSION["jogadores"]);
$locais = carregarProximosDestinosDisponiveis($CARTAS_BASE, $jogador);
?>