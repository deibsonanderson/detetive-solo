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

function exporScriptJs(){
    return '<script type="text/javascript">
        
        	function btnVibrate(){
        		 navigator.vibrate(200);
        	}
        	
            var order = true;
        	function slideUpAndDown(trigger, element, order ){
                $("#"+trigger).click(function(){
                  if(order === true){
                     $("#"+element).slideDown("slow");
                  }else if(order === false){
                     $("#"+element).slideUp("slow");
                  }
                  order = !order;
                });
            	return order;
            }
            
        	$(document).ready(function() {
            	$("#ficha-palpite").hide();           	
                order = slideUpAndDown("texto-ficha", "ficha-palpite", order );
        	});   	
        
        </script>';
}

function montarLink($url, $texto, $class, $isImagem = false, $urlImg = '', $width = '150'){
    if ($isImagem) {
        $imagem = '<img width="'.$width.'" src="./assets/imagens/'.$urlImg.'" class="img-fluid botao-geral" alt="'.$texto.'" >';
        return '<div class="'.$class.'"><a href="'.$url.'" onclick="btnVibrate();" class="botao-total-jogadores">'.$imagem.'</a></br>'.$texto.'</div>';
    } else {
        return '<h1 class="'.$class.'"><a href="'.$url.'" onclick="btnVibrate();">'.$texto.'</a></h1>';
    }
}

function montarLinkFormulario($texto, $class = 'col-md-12'){
    $imagem = '<img width="150" onclick="btnVibrate();" src="./assets/imagens/confirmar.png" class="img-fluid botao-geral" alt="'.$texto.'" >';
    return '<div class="'.$class.'"><a href="#" onclick="document.getElementById(\'myForm\').submit(); return false;">'.$imagem.'</a></br>'.$texto.'</div>';
}

function montarLinkReset($opcional = ''){
    return '<div '.$opcional.'>
                <a href="./index.php?etapa=0" onclick="btnVibrate();" >
                    <img width="50" src="./assets/imagens/sair.png" class="img-fluid botao-reset" alt="Sair!">
                </a>
                </br>Sair!
            </div>
            </br>';
}

function montarExibicaoConometro(){
    return '<div class="clock-container">
                      <div class="digital-clock">
                        <!--span id="hour">00</span>:-->
                        <span id="minute">00</span>:
                        <span id="second">00</span>:
                        <span id="millisecond">000</span>
                      </div>
                      <div onclick="btnVibrate();" >
                        <button id="pause-btn" onclick="cronometroPause();">
                            <img width="85" src="./assets/imagens/pausar.png" class="img-fluid">
                        </button>
                      </div>
                    </div>
                    <p><h5>Tempo restante para a próxima rodada!</h5></p>';
}

function montarLinkAtualizarDestino($class = 'col-md-12'){
    return montarLink('./index.php?etapa=12', 'Atualizar Destino', $class, true, 'atualizar.png');
}

function montarLinkChegueiLocal($class = 'col-md-12'){
    return montarLink('./index.php?etapa=5', 'Cheguei no local!', $class, true, 'destino.png');
}

function montarLinkRealizarPalpiteAcusacao($acusar = false, $class = 'col-md-12'){
    $param = ($acusar) ? '&acusar=true' : '';
    $texto = ($acusar) ? 'Acusar!' : 'Realizar um palpite!';
    $imagem = ($acusar) ? 'acusar.png' : 'investigacao.png';
    return montarLink('./index.php?etapa=6'.$param , $texto , $class, true, $imagem);
}

function montarLinkProximaRodada($class = 'col-md-12'){
    return montarLink('./index.php?etapa=4', 'Proxima Rodada!', $class, true, 'proximo.png');
}

function montarLinkVoltar($class = 'col-md-12'){
    return montarLink('./index.php?etapa=4&voltar=true', 'Voltar!', $class, true, 'voltar.png');
}

function montarLinkExporCarta($class = 'col-md-12'){
    return montarLink('./index.php?etapa=7', 'Expor as Cartas!', $class, true, 'expor.png');
}

function exibirTexto($texto, $opcional = ''){
    return '<h1 '.$opcional.' >'.$texto.'</h1>';
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

function retornarJogadorHumano($jogadores){
    $aux = null;
    foreach ($jogadores as $jogador) {
        if(!$jogador["npc"]){
            $aux = $jogador;
            break;
        }
    }
    return $aux;
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
        
        $img = './assets/imagens/'.recuperarCaminhoImagem($aux["tipo"], $aux["imagem"]);
        
        
        $html .= '<option value="'.$aux["codigo"].'" data-image="'.$img.'" >'.$aux["nome"].'</option>';
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

function validarLocalInicial($inicio, $jogador, $proximoDestino, $cartasBase){
    if(!$inicio){
        return true;
    } else {
        $localInicial = $cartasBase[$jogador["local"]];
        return ($localInicial["codigo"] != $proximoDestino["codigo"]);
    }
    
}

function carregarProximosDestinosDisponiveis($cartasBase, $jogador, $inicio){
    $destinosDisponiveis = listarCartaPeloTipo($cartasBase, 'LOCAL');
    $destinos = null;
    foreach ($destinosDisponiveis as $proximo) {
        if($jogador["destinoAtual"]["codigo"] != $proximo["codigo"] && 
            validarLocalInicial($inicio, $jogador, $proximo, $cartasBase)){
            $destinos[] = $proximo;
        }
    }
        
    return $destinos;
}


function carregarProximoDestino($cartasBase, $jogador, $inicio = false){
    //Obs. Esse metodo não leva em consideração a tabela de palpite pode ser incluindo num futuro
    $destinosDisponiveis = listarLocaisDisponiveisParaRodada($cartasBase, $jogador);
    $retorno = null;
    
    if($jogador["destinoAtual"] == null){
        return $destinosDisponiveis[array_rand($destinosDisponiveis)];
    } else {
        for ($i = 0; $i < count($destinosDisponiveis); $i++) {
            $proximo = $destinosDisponiveis[array_rand($destinosDisponiveis)];
            if($jogador["destinoAtual"]["codigo"] != $proximo["codigo"] && 
                validarLocalInicial($inicio, $jogador, $proximo, $cartasBase)){
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
        $jogador["destinoAtual"] = carregarProximoDestino($cartasBase, $jogador, true);
        $aux[] = $jogador;
    }
    return $aux;
}

function atualizarDestinoJogadorHumano($jogadores, $codigo, $cartasBase){
    $aux = null;    
    $locais = listarCartaPeloTipo($cartasBase, 'LOCAL');
    foreach ($jogadores as $jogador) {
        if(!$jogador["npc"]){
            $jogador["destinoAtual"] = consultarCartaPeloCodigo($codigo, $locais);
        }
        $aux[] = $jogador;
    }
    return $aux;
}

function retornarJogadorDaRodadaAtual($jogadores, $posicao){
    return $jogadores[$posicao];
}

function localizarCriminosoFichaPalpite($criminoso, $carta) {
    return ($criminoso["suspeito"]["codigo"] == $carta["codigo"] || 
        $criminoso["arma"]["codigo"] == $carta["codigo"] || 
        $criminoso["local"]["codigo"] == $carta["codigo"]);
}

function montarFichasDePalpites($jogadores, $cartasBase, $criminoso, $debug = false)
{
    $palpites = null;

    foreach ($jogadores as $jogador) {
        foreach ($cartasBase as $carta) {
           
            if ($debug && localizarCriminosoFichaPalpite($criminoso, $carta)) {
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
    $html =  '<table border="1" class="tabela" id="ficha-palpite">';
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