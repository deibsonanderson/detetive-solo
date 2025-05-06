<?php 

require_once 'cartas.php';
function carregarEtapa($etapa){
    if ($etapa == "0") {
        session_destroy();
        return null;
    } else {
        return $etapa;
    }    
}

function debug($valor){
    echo '<pre>';
    var_dump($valor);
}

function proximaPosicaoJogador($posicao, $listaJogadores){
    if ($posicao >= (count($listaJogadores) - 1)) {
        return 0;
    }
    return $posicao + 1;
}

function retornarPosicaoJogador($posicao, $listaJogadores){
    if ($posicao <= 0) {
        return (count($listaJogadores) - 1);
    }
    return $posicao - 1;
}

function recuperarCaminhoImagem($tipo, $imagem){
    $url = null;
    if ($tipo == 'ARMA') {
        $url = 'armas/' . $imagem;
    } else if ($tipo == 'SUSPEITO') {
        $url = 'suspeitos/' . $imagem;
    } else if ($tipo == 'LOCAL') {
        $url = 'locais/' . $imagem;
    }
    return strpos($imagem, '.png') ? $url : $url . '.png';
}

function consultarCartaPeloCodigo($codigo, $lista){
    foreach ($lista as $chave => $valor) {
        if ($valor["codigo"] == $codigo) {
            return $valor;
        }
    }
    return null;
}

function removerCartaDaListaPeloCodigo($codigo, $lista){
    foreach ($lista as $k => $s) {
        if ($codigo != $s["codigo"]) {
            $aux[] = $s;
        }
    }
    return $aux;
}

function listarCartaPeloTipo($cartasBase, $tipo){
    $cartas = null;
    foreach ($cartasBase as $carta) {
        if ($carta["tipo"] == $tipo) {
            $cartas[] = $carta;
        }
    }
    return $cartas;
}

function montarComboBoxPorLista($lista){
    $html = null;
    foreach ($lista as $aux) {
        $html .= '<option value="'.$aux["codigo"].'">'.$aux["codigo"].' => '.$aux["nome"].'</option>';
    }
    return $html;
}


function listarCartasAgrupadosPorTipos($cartasBase){
    $suspeitos = null;
    $localidades = null;
    $armas = null;
    
    foreach ($cartasBase as $chave => $valor) {
        if ($valor["tipo"] == 'ARMA') {
            $armas[] = $valor;
        } else if ($valor["tipo"] == 'SUSPEITO') {
            $suspeitos[] = $valor;
        } else if ($valor["tipo"] == 'LOCAL') {
            $localidades[] = $valor;
        }
    }
    return array("suspeitos" => $suspeitos, "armas" => $armas, "localidades" => $localidades);
}

function montarCriminoso($cartasBase){
    
    $cartas = listarCartasAgrupadosPorTipos($cartasBase);
    $suspeitos = $cartas["suspeitos"];
    $localidades = $cartas["localidades"];
    $armas = $cartas["armas"];
    
    shuffle($suspeitos);
    shuffle($localidades);
    shuffle($armas);
    
    return array("suspeito" => $suspeitos[0], "arma" => $armas[0], "local" => $localidades[0]);
}

function distribuirCartasParaParticipantes($jogadores, $criminoso, $cartasBase){
    $cartas = null;
    
    foreach ($cartasBase as $carta) {
        if ($carta["codigo"] != $criminoso["suspeito"]["codigo"] &&
            $carta["codigo"] != $criminoso["arma"]["codigo"] &&
            $carta["codigo"] != $criminoso["local"]["codigo"]) {
                $cartas[] = $carta;
            }
    }
    shuffle($cartas);
    
    $totalJogador = (count($jogadores) - 1);
    $contador = 0;
    foreach ($cartas as $carta) {
        $jogadores[$contador]["cartas"][] = $carta;
        ++ $contador;
        
        if ($contador > $totalJogador) {
            $contador = 0;
        }
    }
    
    return $jogadores;
}

function embaralharCarregarNPCs($suspeitos, $numero_participante, $jogadores) {
    shuffle($suspeitos);
    for ($i = 0; $i < ($numero_participante - 1); $i ++) {
        $suspeito = $suspeitos[$i];
        $suspeito["npc"] = true;
        $jogadores[] = $suspeito;
    }
    return $jogadores;
}

function lancarDados($qtdDados){
    $total = 0;
    for ($i = 0; $i < $qtdDados; $i++) {
        $total = $total + rand(1, 6);
    }
    return $total;
}

function listarLocaisDisponiveisParaRodada($cartasBase, $jogador){
    $locais = listarCartaPeloTipo($cartasBase, 'LOCAL');
    $localCodigo = null;
    $cartaCodigo = null;
    foreach ($locais as $l) {
        $localCodigo[] = $l["codigo"];
    }
    foreach ($jogador["cartas"] as $c) {
        if ($c["tipo"] == 'LOCAL') {
            $cartaCodigo[] = $c["codigo"];
        }
    }
    
    $destinoAtual = $jogador["destinoAtual"];
    
    $disponiveis = null;
    
    if($cartaCodigo != null){
        $filtrado = array_diff($localCodigo, $cartaCodigo);
    } else {
        $filtrado = $localCodigo;
    }
    
    foreach ($filtrado as $filtradoCodigo) {
        if ($destinoAtual != null && $destinoAtual == $filtradoCodigo) {
            continue;
        }
        $disponiveis[] = consultarCartaPeloCodigo($filtradoCodigo, $locais);
    }
    
    return $disponiveis;
}

function carregarProximoDestino($cartasBase, $jogador){
    //Obs. Esse metodo não leva em consideração a tabela de palpite pode ser incluindo num futuro
    $destinosDisponiveis = listarLocaisDisponiveisParaRodada($cartasBase, $jogador);
    $retorno = null;
    if($jogador["destinoAtual"] == null){
        return $destinosDisponiveis[array_rand($destinosDisponiveis)];
    } else {
        foreach ($destinosDisponiveis as $destino) {
            $proximo = $destinosDisponiveis[array_rand($destinosDisponiveis)];
            if($jogador["destinoAtual"]["codigo"] != $proximo["codigo"]){
                $retorno = $proximo;
                break;
            }
        }
        
        //Esse fluxo serve como escape para quado todas cartas de locais acabarem
        if($retorno == null){
            $destinosDisponiveis[array_rand($destinosDisponiveis)];
        }
        
        return $retorno;
    }
}

function montarDestinosIniciaisJogadores($cartasBase, $jogadores){
    $aux = null;
    foreach ($jogadores as $jogador) {
        $jogador["destinoAtual"] = carregarProximoDestino($cartasBase, $jogador);
        $aux[] = $jogador;
    }
    return $aux;
}

function retornarJogadorDaRodadaAtual($jogadores, $posicao){
    return $jogadores[$posicao];
}

function montarFichasDePalpites($jogadores, $cartasBase, $criminoso)
{
    $palpites = null;

    foreach ($jogadores as $jogador) {
        foreach ($cartasBase as $carta) {

            if ($criminoso["suspeito"]["codigo"] == $carta["codigo"] || 
                $criminoso["arma"]["codigo"] == $carta["codigo"] || 
                $criminoso["local"]["codigo"] == $carta["codigo"]) {
                $carta["marcado"] = 2;
            } else {
                $carta["marcado"] = 0;
            }

            foreach ($jogador["cartas"] as $cartaJogador) {
                if ($cartaJogador["codigo"] == $carta["codigo"]) {
                    $carta["marcado"] = 1;
                    break;
                }
            }
            $jogador["palpites"][$carta["tipo"]][] = $carta;
        }
        $palpites[] = $jogador;
    }

    return $palpites;
}

function exibirFichaPalpites($palpites){
    $html =  '<table border="1" class="tabela">';
    foreach ($palpites as $chave => $palpite) {
        $html .= '<thead>
                    <tr><th colspan="2" class="tipoFicha">'.$chave.'</th></tr>
                  </thead>
                  <tbody>';
        foreach ($palpite as $carta) {
            
            if($carta["marcado"] == 2){
                $marcado = 'O';
            } else if($carta["marcado"] == 1){
                $marcado = 'X';
            }else{
                $marcado = '';
            }
            
            $html .= '<tr><td>'.$carta["nome"].'</td><td class="fichaMarcada">'.$marcado.'</td></tr>';
        }
        $html .= '</tbody>';
    }
    $html .= '</table>';
    return $html;
}

function atualizarPalpitesDosJogadores($jogadores, $encontrada){
    //esse fluxo é responsavel por atualizar a ficha de palpite dos demais jogadores 
    $aux = null;
    foreach ($jogadores as $jogador) {
        $palpites = null;
        foreach ($jogador["palpites"] as $chave => $palpite) {
            foreach ($palpite as $carta) {
                if ($encontrada["codigo"] == $carta["codigo"]) {
                    $carta["marcado"] = 1;
                }
                $palpites[$chave][] = $carta;
            }
        }
        $jogador["palpites"] = $palpites;
        $aux[] = $jogador;
    }
    return $aux;
}

function removerJogador($jogadores, $jogador){
    $aux = null;
    foreach ($jogadores as $j) {
        if($j["codigo"] != $jogador["codigo"]){
            $aux[] = $j;
        }
    }
    return $aux;
}

function localizarProximoJogadorComCartaPalpite($proximaPosicao, $jogadores, $palpite){
    $suspeito = $palpite["suspeito"];
    $arma = $palpite["arma"];
    $local = $palpite["local"]; // $filtrados["LOCAL"][0];
    $aux = null;
    for ($i = 0; $i < count($jogadores); $i++) {
        $encontradas = null;
        $proximaPosicao = proximaPosicaoJogador($proximaPosicao, $jogadores);
        $jogador = $jogadores[$proximaPosicao];
        foreach ($jogador["cartas"] as $carta) {
            if($carta["codigo"] == $suspeito["codigo"] ||
                $carta["codigo"] == $arma["codigo"] ||
                $carta["codigo"] == $local["codigo"]){
                    $encontradas[] = $carta;
            }
        }
        if($encontradas != null && count($encontradas) >= 1){
            $aux = array("jogador" => $jogador, "encontradas" => $encontradas);
            break;
        }
    }
    return $aux;
}

function montarHtmlFichaDebug(){
    $html = '<div class="row"><div class="col-md-12"><table><tr>';
    if($_SESSION["jogadores"] != null && count($_SESSION["jogadores"]) > 0){
        foreach ($_SESSION["jogadores"] as $chave => $jogador) {
            $palpites = $jogador["palpites"];
            if($palpites != null && count($palpites) > 0){
                $x = ($jogador["npc"])?'N':'H';
                $html .= '<td>'.$chave.'-'.$jogador["nome"].'-'.$x.'</br>'.
                    exibirFichaPalpites($palpites).'</td>';
            }
        }
        $html .= '</tr></table></div></div>';
    }
   
    if($_SESSION["criminoso"] != null && count($_SESSION["criminoso"]) > 0){
        $html .= '<b>Criminoso:</b></br>';
        foreach ($_SESSION["criminoso"] as $chave => $value) {
            
            $html .= $value["nome"].'-'.$value["tipo"].'</br>';
        }
    }
    return $html;
}

$_SESSION["etapa"] = carregarEtapa($_GET["etapa"]);
?>