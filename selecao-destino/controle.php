<?php 
    $jogador = retornarJogadorHumano($_SESSION["jogadores"]);
    $locais = carregarProximosDestinosDisponiveis($CARTAS_BASE, $jogador);
?>