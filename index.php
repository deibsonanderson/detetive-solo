<?php require_once 'funcoes.php'; ?>
<!DOCTYPE html>
<html>
<head>
<?php require_once 'head.php'; ?>
</head>
<body class="bg">
<img id="jogar-dados" src="./assets/imagens/jogar_dados.gif" class="imagem-direita" style="display: none;">
	<div class="container">
		<h4><a href="./index.php?etapa=0">Resetar</a></h4></br>
<?php
if(!isset($_SESSION["etapa"]) || $_SESSION["etapa"] == "0"){ //Selecionar a quantidade de jogadores ***************************************************
?>	
    	
    	<h1>Escolha o total de jogadores!!!</h1>
    	<div class="row">
        <?php
        for ($i = 1; $i < 7; $i++) {
            $html  = '<div class="col-md-6">';
            $html .=      '<a href="./index.php?etapa=1&numero='.$i.'"><img width="400" src="./assets/imagens/numeros/' . $i . '.png" class="img-fluid"></a>';
            $html .= '</div>';
            echo $html;
        }
        ?>    
    	</div>
	
<?php
} else if($_SESSION["etapa"] == "1" ){ //Selecionar um personagem *******************************************************************************
    
    $_SESSION["numero_participante"] = $_GET["numero"];
    
?>  
		
		<h1>Escolha o seu personagem!!!</h1>
		<div class="row">
        <?php
        $suspeitos = listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO');
        foreach ($suspeitos as $s) {
            $html = '<div class="col-md-6">';
            $html .= '<a href="./index.php?etapa=2&jogador='.$s["codigo"].'"><img width="400" src="./assets/imagens/suspeitos/' . $s["imagem"] . '" class="img-fluid"></a>';
            $html .= '</div>';
            echo $html;
        }
        $suspeitos = null;
        ?>    
  		</div>
  		
<?php   

} else if($_SESSION["etapa"] == "2" ){ //Selecione a quantidade de dados & SETUP **************************************************************
    
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
	
		<h1>Selecione a quantidade de dados!!!</h1>
		<div class="row">
        <?php
        for ($i = 1; $i <= 2; $i++) {
            $html  = '<div class="col-md-6">';
            $html .=      '<a href="./index.php?etapa=3&qtd_dados='.$i.'"><img width="400" src="./assets/imagens/numeros/' . $i . '.png" class="img-fluid"></a>';
            $html .= '</div>';
            echo $html;
        }
        ?>    
  		</div>
	
<?php 
} else if($_SESSION["etapa"] == "3" ){  //Exibir cartas do jogador, definir a ordem dos participantes, ******************************************  
    unset($_SESSION["numero_participante"]);
    unset($_SESSION["jogador"]);
    
    $_SESSION["qtd_dados"] = $_GET["qtd_dados"];
    $jogadores = $_SESSION["jogadores"];
 
?>
	
		<h1>Jogador anote suas cartas - <a href="./index.php?etapa=4">Iniciar!!!</a></h1>
		<div class="row">
        <?php
        foreach ($jogadores as $jogador) {
            if(!$jogador["npc"]){
                foreach ($jogador["cartas"] as $carta){
                    $html  = '<div class="col-md-6">';
                    $html .=      '<img width="400" src="./assets/imagens/'. recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]) . '" class="img-fluid">';
                    $html .= '</div>';
                    echo $html;
                }
                break;
            }
        }
        ?>        
  		</div>

<?php 
} else if($_SESSION["etapa"] == "4"){ //A funcção dessa etapa é navegar entre os jogadores e disponibiizar os botões para realizar alguma ação.*********
    
    //carrega a posisão do proximo jogador na memoria
    if(!$_GET["voltar"]){
        $_SESSION["posicao_jogador"] = proximaPosicaoJogador($_SESSION["posicao_jogador"], $_SESSION["jogadores"]);
    }
    
    $jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);
    
    $cronometro = '<div class="clock-container">
                      <div class="digital-clock">
                        <!--span id="hour">00</span>:-->
                        <span id="minute">00</span>:
                        <span id="second">00</span><!--:
                        <span id="millisecond">000</span-->
                      </div>
                      <button id="pause-btn" onclick="cronometroPause();">Pausar</button>
                    </div>';
    //$cronometro = ($jogador["npc"]) ? $cronometro : '';

    // Os dados que o NPC vai jogar
    $totalDados = lancarDados($_SESSION["qtd_dados"]);
    
?>
	<p><h1><?php echo $jogador["nome"].'.'; ?></h1></p>	
	<p><img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid"></p>
	<p><h1><?php echo ($jogador["npc"])? ' É um NPC.' : 'É um Jogador Humano.'; ?></h1></p>
	<p>
    	<h1>Total de casas que pode movimentar é: 
    		<span id="dados-numero" style="display: none;"><?php echo $totalDados; ?></span>
    	</h1>
	</p>
	<p><h1><?php echo 'Seu destino atual é: '.$jogador["destinoAtual"]["nome"].'</br>'; ?></h1></p>
	
	<?php echo $cronometro; ?>
	<p><h5>Tempo restante para a próxima rodada!</h5></p>
	<h1><a href="./index.php?etapa=4">Proxima Rodada!</a></h1>
	<h1><a href="./index.php?etapa=5">Cheguei no local!</a></h1>
	<script type="text/javascript">
		$(document).ready(function() {
        	$('#jogar-dados').show();        	
        	setTimeout(function() {
              $('#jogar-dados').fadeOut('slow');
              $('#dados-numero').fadeIn('slow');
              cronometroStart();
            }, 1500);
		});  	
	</script>
<?php 
} else if($_SESSION["etapa"] == "5"){ //Essa etapa so tem a função de listar as ações que serão escolhidas!!!! *****************************************
    
    //o jogador é listado para ser exibido
    $jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);
    
    $btnPalpite = '<h1><a href="./index.php?etapa=6">Realizar um palpite!</a></h1>';
    $btnAcusar = '<h1><a href="./index.php?etapa=6&acusar=true">Acusar!</a></h1>';
    
?>

    <p><h1><?php echo $jogador["nome"].'.'; ?></h1></p>
    <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid"></p>	
	<?php
    if ($jogador["npc"]) {

        $total = 0;
        foreach ($jogador["palpites"] as $chave => $palpite) {
            foreach ($palpite as $carta) {
                if ($carta["marcado"] == 0) {
                    $total ++;
                }
            }
        }

        echo ($total == 0) ? $btnAcusar : $btnPalpite.$btnAcusar;
    
    } else {

        echo $btnPalpite . $btnAcusar;
    }
	
	?>
	<!-- h1><a href="./index.php?etapa=4">Ir para uma passagem secreta!</a></h1-->
	<h1><a href="./index.php?etapa=4&voltar=true">Voltar!</a></h1>

<?php 
} else if($_SESSION["etapa"] == "6"){ // Essa etapa tem a função de expor as cartas que o NPC fez os palpites ******************************************
    
    $jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);
    
    if($jogador["npc"]){
    // INICIO NPC --------------------------------------------------------------------    
        
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
        
        //TODO: Pensar em como vai funcionar o fluxo de acusação do NPC
        
        if($_GET["acusar"]){        
            header("Location: ./index.php?etapa=10&suspeito=".$suspeito["codigo"]."&arma=".$arma["codigo"]."&local=".$local["codigo"]);
            die();
        }
        
        $_SESSION["palpite"] = array("suspeito" => $suspeito, "arma" => $arma, "local" => $local);
        
        //Como ele acabou de fazer um palpite o destino dele deve mudar
        foreach ($_SESSION["jogadores"] as $key => $j) {
            if($j["codigo"] == $jogador["codigo"]){
                $_SESSION["jogadores"][$key]["destinoAtual"] = carregarProximoDestino($CARTAS_BASE, $j);
                break;
            }
        }
        
        
        ?>
        <div style="text-align: center;">
            <h1>O NPC <?php echo $jogador["nome"]; ?>, fez o palpite com as cartas: </h1>
            <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $suspeito["imagem"]; ?>" class="img-fluid"></p>	
            <p><img width="200" src="./assets/imagens/armas/<?php echo $arma["imagem"]; ?>" class="img-fluid"></p>	
            <p><img width="200" src="./assets/imagens/locais/<?php echo $local["imagem"]; ?>" class="img-fluid"></p>	
        	<h1><a href="./index.php?etapa=7">Expor as Cartas!!!</a></h1>
    	</div>
		<?php
	// FINAL NPC ---------------------------------------------------------------------   
    } else {
    // INICIO JOGADOR HUMANO  --------------------------------------------------------   
        $suspeitos = listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO');
        $armas = listarCartaPeloTipo($CARTAS_BASE, 'ARMA');
        $locais = listarCartaPeloTipo($CARTAS_BASE, 'LOCAL');
        
        $etapa = ($_GET["acusar"])?"10":"9";
        
        ?>
        <h1>Selecine cada um dos tipos de cartas!</h1></br>
        <div class="row">
        	<form action="./index.php" method="get" class="col-md-6 tabela">
    			<input type="hidden" name="etapa" value="<?php echo $etapa; ?>">
    			<div class="form-group">
    				<label for="suspeito">Suspeito</label> <select name="suspeito" id="suspeito" class="form-control form-control-lg">
                		<?php echo montarComboBoxPorLista($suspeitos); ?>
            		</select>
    			</div>
    			<div class="form-group">
    				<label for="arma">Arma</label> 
    				<select name="arma" id="arma" class="form-control form-control-lg">
    					<?php echo montarComboBoxPorLista($armas); ?>
    				</select>
    			</div>
    			<div class="form-group">
    				<label for="local">Local</label> 
    				<select name="local" id="local" class="form-control form-control-lg">
    					<?php echo montarComboBoxPorLista($locais); ?>
    				</select>
    			</div>
    			<div class="form-group">
        			<h1 style="float: left;"><a href="./index.php?etapa=4&voltar=true">Voltar!</a></h1>&nbsp;&nbsp;
        			<button type="submit" class="btn btn-primary">Confirmar!</button>
    			</div>
    		</form>
		</div>
		<h1>Revise a sua Ficha de Palpites!</h1>		
		<?php
		echo exibirFichaPalpites($jogador["palpites"]);
	// FINAL JOGADOR HUMANO  --------------------------------------------------------  
    }
    
} else if ($_SESSION["etapa"] == "7") {//Essa etapa é reponsavel pela exposição das cartas que foi usada no palpite e que não é suspeito **************
    
    $aux = localizarProximoJogadorComCartaPalpite($_SESSION["posicao_jogador"], $_SESSION["jogadores"], $_SESSION["palpite"]);
    
    if($aux == null || count($aux["encontradas"]) == 0) {
        
        ?>
    		<h1>Nenhuma carta foi localizada!!!!</h1>
    		<h1><a href="./index.php?etapa=4">Proxima Rodada!</a></h1>
		<?php
        
    } else {

        $jogadorEncontrado = $aux["jogador"];
        $encontradas = $aux["encontradas"];
        
        //Esse embaralhamento é para escolher uma das cartas para incluir no palpite do jogador atual antes de trocar
        shuffle($encontradas);
        if ($jogadorEncontrado["npc"]) {
            
            // Apos o palpite se o proximo da vez for um NPC você deve ele escolhe uma das cartas selecionada e ja marca como descartadas
            $_SESSION["jogadores"] = atualizarPalpitesDosJogadores($_SESSION["jogadores"], $encontradas[0]);
            
            ?>
        		<h1>A carta localizada do jogador, <?php echo $jogadorEncontrado["nome"]; ?> é:</h1>
        		<p><img width="400" src="./assets/imagens/<?php echo recuperarCaminhoImagem($encontradas[0]["tipo"], $encontradas[0]["imagem"]); ?>" class="img-fluid"></p>
        		<h1><a href="./index.php?etapa=4">Proxima Rodada!</a></h1>
    		<?php
		
        } else {
            
            echo "<p><h1>Jogador Humano - " . $jogadorEncontrado["nome"] . ' selecione uma das cartas</h1></p>';
            $html = '<div class="col-md-12">';
            foreach ($encontradas as $encontrada) {
                $html .= '<a href="./index.php?etapa=8&carta='.$encontrada["codigo"].'"><img width="400" src="./assets/imagens/' . recuperarCaminhoImagem($encontrada["tipo"], $encontrada["imagem"]) . '" class="img-fluid"></a>';
            }
            $html .= '</div>';
            $html .= '<h1><a href="./index.php?etapa=4&voltar=true">Voltar!</a></h1>';
            echo $html;
        }
        
    }
    
    
} else if($_SESSION["etapa"] == "8"){ //Essa etapa é exlusiva do jogador humano para que possa escolher uma das cartas informada no palpite ***********
    
    $carta = consultarCartaPeloCodigo($_GET["carta"], $CARTAS_BASE);
    
    $_SESSION["jogadores"] = atualizarPalpitesDosJogadores($_SESSION["jogadores"], $carta);
    
    // se o proxmo da vez for o Jogador Humano você precisa selecionar uma das suas cartas
    $palpites = $_SESSION["jogadores"][$_SESSION["posicao_jogador"]]["palpites"];    
    ?>
    <p><img width="400" src="./assets/imagens/<?php echo recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]); ?>" class="img-fluid"></p>
    <!-- div class="row"><div class="col-md-12"><?php echo exibirFichaPalpites($palpites); ?></div></div-->
    <h1><a href="./index.php?etapa=4">Proxima Rodada!</a></h1>
    <?php
    
} else if($_SESSION["etapa"] == "9"){ //Essa etapa é responsavel pela exibição dos palpites realizados pelo jogador humano

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
    <h1>As cartas selecionadas pelo Jogador Humano foram:</h1>
    <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $suspeito["imagem"]; ?>" class="img-fluid"></p>	
    <p><img width="200" src="./assets/imagens/armas/<?php echo $arma["imagem"]; ?>" class="img-fluid"></p>	
    <p><img width="200" src="./assets/imagens/locais/<?php echo $local["imagem"]; ?>" class="img-fluid"></p>	
    <h1><a href="./index.php?etapa=7">Expor as Cartas!!!</a></h1>
    <?php

} else if($_SESSION["etapa"] == "10"){ //Essa etapa é responsavel pela desfecho da acusação se foi com sucesso ou falha ****************************
    
    
    $suspeito = $_SESSION["criminoso"]["suspeito"];
    $arma = $_SESSION["criminoso"]["arma"];
    $local = $_SESSION["criminoso"]["local"]; 
    
    $sucesso = ($suspeito["codigo"] == $_GET["suspeito"] && $arma["codigo"] == $_GET["arma"] && $local["codigo"] == $_GET["local"]);
        
    $jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);
    if($jogador["npc"]){
        
        if($sucesso){
         
            echo '<h1 style="text-align: center;">Infelizmente você não conseguiu identificar o verdadeiro assassino, o jogador '.$jogador["nome"].' é o verdadeiro DETETIVE!</h1>';
            echo '<p style="text-align: center;"><img width="200" src="./assets/imagens/game_over.png" class="img-fluid"></p>';
            
        } else {
            
            //Esse fluxo é reponsavel por reorganizar a posição do proximo jogador
            $_SESSION["jogadores"] = removerJogador($_SESSION["jogadores"], $jogador);
            if ($_SESSION["posicao_jogador"] < count($_SESSION["jogadores"])) {
                $_SESSION["posicao_jogador"] = retornarPosicaoJogador($_SESSION["posicao_jogador"], $_SESSION["jogadores"]);
            }            
            
            if(count($_SESSION["jogadores"]) == 1){
            
                echo '<h1 style="text-align: center;">Você é único investigador que sobrou, agora é a hora de provar que você é um DETETIVE de verdade!!!</h1>';
                echo '<h1 style="text-align: center;"><a href="./index.php?etapa=6&acusar=true">Acusar!</a></h1>';
                
            } else {
               
                echo '<h1 style="text-align: center;">Infelizmente o NPC '.$jogador["nome"].', não conseguiu identificar o verdadeiro assassino, por conta disso ele acabou escapando!</h1>';
                echo '<p style="text-align: center;"><img width="200" src="./assets/imagens/suspeitos/'.$jogador["imagem"].'" class="img-fluid"></p>';
                echo '<h1><a href="./index.php?etapa=4">Proxima Rodada!</a></h1>';
            
            }            
        }
        
    } else {
    
        if($sucesso){
            
            echo '<h1 style="text-align: center;">Parabéns você conseguiu identificar o verdadeiro assassino e acaba de ser promovido à DETETIVE!!!</h1>';
            echo '<p style="text-align: center;"><img  src="./assets/imagens/detetive.png" class="img-fluid"></p>';
        
        } else {
            
            echo '<h1 style="text-align: center;">Infelizmente você não conseguiu identificar o verdadeiro assassino, por conta disso ele acabou escapando!</h1>';
            echo '<p style="text-align: center;"><img width="200" src="./assets/imagens/game_over.png" class="img-fluid"></p>';
            
        }
        ?><h1><a href="./index.php?etapa=0">Reiniciar</a></h1></br><?php 
    }
}
//echo montarHtmlFichaDebug();
?>
</body>
</html>