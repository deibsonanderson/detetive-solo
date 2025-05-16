<?php 
$jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);

if($jogador["npc"]){
    
    $destinoAtual = $jogador["destinoAtual"];
    
    // Esse fluxo é responsavel por carregar as cartas que estão elegiveis para o palpite do NPC
    $filtrados = null;
    foreach ($jogador["palpites"] as $chave => $palpite) {
        foreach ($palpite as $carta) {
            if ($carta["marcado"] != 1) {
                $filtrados[$chave][] = $carta;
            }
        }
        if($filtrados != null && $filtrados[$chave]){
            shuffle($filtrados[$chave]);
        }
    }
    
    //aqui é seleciona um tipo de carta para cada palpite
    $suspeito = $filtrados["SUSPEITO"][0];
    $arma = $filtrados["ARMA"][0];
    $local = ($_GET["acusar"]) ? $filtrados["LOCAL"][0] : $destinoAtual;
    
    if($_GET["acusar"]){
        $url = "./index.php?etapa=10&suspeito=".$suspeito["codigo"]."&arma=".$arma["codigo"]."&local=".$local["codigo"];
        $html = '<script>window.location.href = "'.$url.'";</script>';
        echo $html;
    }
    
    $_SESSION["palpite"] = array("suspeito" => $suspeito, "arma" => $arma, "local" => $local);
    
    //Como ele acabou de fazer um palpite o destino dele deve mudar
    foreach ($_SESSION["jogadores"] as $key => $j) {
        if($j["codigo"] == $jogador["codigo"]){
            $_SESSION["jogadores"][$key]["destinoAtual"] = carregarProximoDestino($CARTAS_BASE, $j);
            break;
        }
    }
    
} else {
    
    $suspeitos = listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO');
    $armas = listarCartaPeloTipo($CARTAS_BASE, 'ARMA');
    $locais = listarCartaPeloTipo($CARTAS_BASE, 'LOCAL');
    
    $etapa = ($_GET["acusar"])?"10":"9";
    
}
?>