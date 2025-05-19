<?php 
$carta = consultarCartaPeloCodigo($_GET["carta"], $CARTAS_BASE);

$_SESSION["jogadores"] = atualizarPalpitesDosJogadores($_SESSION["jogadores"], $carta);

//Recupera o jogador que é o dono da carta
$jogadorDonoCarta = recuperarJogadorPeloCodigo($_SESSION["jogadores"], $_GET["donoCarta"]);

// se o proxmo da vez for o Jogador Humano você precisa selecionar uma das suas cartas
$jogador = $_SESSION["jogadores"][$_SESSION["posicao_jogador"]];

//$palpites = $jogador["palpites"];    
?>