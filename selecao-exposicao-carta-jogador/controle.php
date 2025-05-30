<?php
$totalLocalizados = localizarProximoJogadorComCartaPalpite($_SESSION["posicao_jogador"], $_SESSION["jogadores"], $_SESSION["palpite"]);
$jogadorEncontrado = $totalLocalizados["jogador"];
$encontradas = $totalLocalizados["encontradas"];

$acao = null;
if ($totalLocalizados == null || count($totalLocalizados["encontradas"]) == 0) {
    $acao = 0;
} else {
    // Esse embaralhamento é para escolher uma das cartas para incluir no palpite do jogador atual antes de trocar
    shuffle($encontradas);
    if ($jogadorEncontrado["npc"]) {
        // Apos o palpite se o proximo da vez for um NPC você deve ele escolhe uma das cartas selecionada e ja marca como descartadas
        $_SESSION["jogadores"] = atualizarPalpitesDosJogadores($_SESSION["jogadores"], $encontradas[0]);
        $acao = 1;
    } else {
        // Apos o palpite se o proximo da vez for o jogador humano você deve ele escolhe uma das cartas selecionada e ja marca como descartadas
        $acao = 2;
        
        //Caso o jogador humano so tenho 1 carta não é necessário clicar sendo redirecionado automaticamente para a pagina que exibe uma das cartas do palpite
        $totalEncontradas = count($encontradas);
        if($totalEncontradas == 1){
            echo '<script>window.location.href = "./index.php?etapa=8&carta=' . $encontradas[0]["codigo"] . '&donoCarta='.$jogadorEncontrado["codigo"].'";</script>';
        }
    }
}
?>