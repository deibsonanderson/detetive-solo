<?php 

$_SESSION["jogador"] = $_GET["jogador"];

// selecionar as cartas do criminosso
$_SESSION["criminoso"] = montarCriminoso($CARTAS_BASE);

// escolher o jogador com base no numero
$_SESSION["jogadores"][] = consultarCartaPeloCodigo($_SESSION["jogador"], listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO'));
$_SESSION["jogadores"][0]["npc"] = false;

// removendo o jogador selecionado da lista de suspeitos
$suspeitos = removerCartaDaListaPeloCodigo($_SESSION["jogador"], listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO'));

// embaralhar os suspeitos sem o jogador escolhido e escolher os NPCs de acordo com a quantidade
$_SESSION["jogadores"] = embaralharCarregarNPCs($suspeitos, $_SESSION["numero_participante"], $_SESSION["jogadores"]);

// distribuição das cartas dos participantes
$_SESSION["jogadores"] = distribuirCartasParaParticipantes($_SESSION["jogadores"], $_SESSION["criminoso"], $CARTAS_BASE);

//Montar a Ficha dos palpites
$_SESSION["jogadores"] = montarFichasDePalpites($_SESSION["jogadores"], $CARTAS_BASE, $_SESSION["criminoso"]);

//carrega o destino de todos jogadores durante a inicialização
$_SESSION["jogadores"] = montarDestinosIniciaisJogadores($CARTAS_BASE, $_SESSION["jogadores"]);

//sortear a ordem dos jogaores
shuffle($_SESSION["jogadores"]);

//inicializar a posição do jogar que vai iniciar a jogatina
$_SESSION["posicao_jogador"] = 0;

?>