<?php 
$carta = consultarCartaPeloCodigo($_GET["carta"], $CARTAS_BASE);

$_SESSION["jogadores"] = atualizarPalpitesDosJogadores($_SESSION["jogadores"], $carta);

// se o proxmo da vez for o Jogador Humano você precisa selecionar uma das suas cartas
$palpites = $_SESSION["jogadores"][$_SESSION["posicao_jogador"]]["palpites"];    
?>