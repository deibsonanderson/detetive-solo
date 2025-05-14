<?php 
require_once 'funcoes.php'; 
error_reporting (E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_WARNING);
?>

<!DOCTYPE html>
<html>
<head>
<?php require_once 'head.php'; ?>
</head>
<body class="bg">
<img id="jogar-dados" src="./assets/imagens/jogar_dados.gif" class="imagem-direita" style="display: none;">
	<div class="container" style="text-align: center;">
<?php
echo montarLinkReset();

if(!isset($_SESSION["etapa"]) || $_SESSION["etapa"] == "0"){ //Selecionar a quantidade de jogadores ***************************************************

        echo exibirTexto('Escolha o total de jogadores!');    
?>	
    	
    	</br></br>
    	<div class="row">
        <?php
        for ($i = 3; $i < 7; $i++) {
            $html  = '<div class="col-md-6">';
            $html .=      '<a href="./index.php?etapa=1&numero='.$i.'"><img width="400" src="./assets/imagens/numero-jogadores/' . $i . '.png" class="img-fluid botao-total-jogadores" onclick="btnVibrate();"></a>';
            $html .= '</div>';
            echo $html;
        }
        ?>    
    	</div>
	
<?php
} else if($_SESSION["etapa"] == "1" ){ //Selecionar um personagem *******************************************************************************
    
    $_SESSION["numero_participante"] = $_GET["numero"];
    echo exibirTexto('Escolha o seu personagem!');   
?>  
		
		</br></br>
		<div class="row">
        <?php
        $suspeitos = listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO');
        foreach ($suspeitos as $s) {
            $html = '<div class="col-md-6">';
            $html .= '<a href="./index.php?etapa=2&jogador='.$s["codigo"].'"><img width="400" src="./assets/imagens/suspeitos/' . $s["imagem"] . '" class="img-fluid" onclick="btnVibrate();"></a>';
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
    
    echo exibirTexto('Selecione a quantidade de dados!');   
    
?>
	
		</br></br>
		<?php
        for ($i = 1; $i <= 3; $i++) {
            $html  = '<div class="row">';
            $html .= '  <div class="col-md-12" style="margin-bottom:30px;">';
            $html .=      '<a href="./index.php?etapa=3&qtd_dados='.$i.'"><img width="400" src="./assets/imagens/dados/' . $i . '.png" class="img-fluid botao-dados" onclick="btnVibrate();"></a>';
            $html .= '  </div>';
            $html .= '</div>';
            echo $html;
        }
        ?>      		
	
<?php 
} else if($_SESSION["etapa"] == "3" ){  //Exibir cartas do jogador, definir a ordem dos participantes, ******************************************  
    unset($_SESSION["numero_participante"]);
    unset($_SESSION["jogador"]);
    
    $_SESSION["qtd_dados"] = $_GET["qtd_dados"];   
    $jogador = retornarJogadorHumano($_SESSION["jogadores"]);
    $locais = carregarProximosDestinosDisponiveis($CARTAS_BASE, $jogador);
    
    echo exibirTexto('Selecine um destino!');   
?>
    </br>
    <div class="row">
    	<form action="./index.php" method="get" id="myForm" class="col-md-6 tabela" >
			<input type="hidden" name="etapa" value="11">
			<div class="form-group">
				<select name="local" id="local" class="form-control form-control-lg" style="font-size: xx-large;">
					<?php echo montarComboBoxPorLista($locais); ?>
				</select>
			</div>
			<div class="form-group">
    			<h1>
        			<a href="#" onclick="document.getElementById('myForm').submit(); return false;">
        				<img width="200" src="./assets/imagens/comecar.png" onclick="btnVibrate();" class="img-fluid botao-iniciar">
        			</a>
    			</h1>
			</div>
		</form>
	</div>

	<?php echo exibirTexto('Jogador anote suas cartas!');  ?>
	</br></br>
	<div class="row">
    <?php
    foreach ($jogador["cartas"] as $carta){
        $html  = '<div class="col-md-6">';
        $html .=      '<img width="400" src="./assets/imagens/'. recuperarCaminhoImagem($carta["tipo"], $carta["imagem"]) . '" class="img-fluid">';
        $html .= '</div>';
        echo $html;
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
                      <div onclick="btnVibrate();" >
                        <button id="pause-btn" onclick="cronometroPause();">
                            <img width="85" src="./assets/imagens/pausar.png" class="img-fluid">
                        </button>
                      </div>
                    </div>
                    <p><h5>Tempo restante para a próxima rodada!</h5></p>';
    
    // Os dados que o NPC vai jogar
    $totalDados = lancarDados($_SESSION["qtd_dados"]);
    
?>
	<p><h1><?php echo $jogador["nome"].'.'; ?></h1></p>	
	<p><img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid"></p>
	<p><h1><img width="80" src="./assets/imagens/<?php echo ($jogador["npc"])? 'computador.png' : 'humano.png'; ?>" class="img-fluid"></h1></p>
	<p><h1>Movimente <span id="dados-numero" style="display: none; font-size: larger; color: RED;"><?php echo $totalDados; ?></span> casas!</h1></p>
	<p><?php echo exibirTexto('Seu destino atual é: '.$jogador["destinoAtual"]["nome"]).'</br>'; ?></p>
	
	<?php echo $cronometro; ?>
	<div class="row">
		<?php
		  $html = '';
		  if ($jogador["npc"]) {
		      $html .= montarLinkProximaRodada('col-md-6');
		      $html .= montarLinkChegueiLocal('col-md-6');		      
		  } else {
		      $html .= montarLinkProximaRodada('col-md-4');
		      $html .= montarLinkChegueiLocal('col-md-4');
		      $html .= montarLinkAtualizarDestino('col-md-4');
		  }	
		  echo $html;
	?>
	</div>
	<?php 
	if(!$jogador["npc"]){
	    
	    echo '</br>'.exibirTexto('Revise a sua Ficha de Palpites!', 'id="texto-ficha"').'</br>';
    	echo exibirFichaPalpites($jogador["palpites"]);
	}
	?>
	<script type="text/javascript">
		$(document).ready(function() {
        	$('#jogar-dados').show();
        	$('#ficha-palpite').hide();           	
        	setTimeout(function() {
              $('#jogar-dados').fadeOut('slow');
              $('#dados-numero').fadeIn('slow');
              cronometroStart();
            }, 1500);
            
            order = slideUpAndDown('texto-ficha', 'ficha-palpite', order );
		}); 
	</script>
<?php 
} else if($_SESSION["etapa"] == "5"){ //Essa etapa so tem a função de listar as ações que serão escolhidas!!!! *****************************************
    
    //o jogador é listado para ser exibido
    $jogador = retornarJogadorDaRodadaAtual($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);
    
?>

    <p><h1><?php echo $jogador["nome"].'.'; ?></h1></p>
    <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid"></p>
	<?php
	echo '<div class="row">';
    if ($jogador["npc"]) {

        $total = 0;
        foreach ($jogador["palpites"] as $chave => $palpite) {
            foreach ($palpite as $carta) {
                if ($carta["marcado"] == 0) {
                    $total ++;
                }
            }
        }

        echo ($total == 0) ? montarLinkRealizarPalpiteAcusacao(true,'col-md-6') : montarLinkRealizarPalpiteAcusacao(false, 'col-md-6');
        echo montarLinkVoltar('col-md-6');
    
    } else {

        echo montarLinkRealizarPalpiteAcusacao(false, 'col-md-4');
        echo montarLinkRealizarPalpiteAcusacao(true, 'col-md-4');
        echo montarLinkVoltar('col-md-4');
    }
    echo '</div>';
    if(!$jogador["npc"]){
	    echo '</br>'.exibirTexto('Revise a sua Ficha de Palpites!', 'id="texto-ficha"').'</br>';
    	echo exibirFichaPalpites($jogador["palpites"]);
	}
	?>
	
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
        
        ?>
        <div style="text-align: center;">
            <?php echo exibirTexto('O NPC '.$jogador["nome"].', fez o palpite com as cartas: '); ?>            
            <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $suspeito["imagem"]; ?>" class="img-fluid"></p>	
            <p><img width="200" src="./assets/imagens/armas/<?php echo $arma["imagem"]; ?>" class="img-fluid"></p>	
            <p><img width="200" src="./assets/imagens/locais/<?php echo $local["imagem"]; ?>" class="img-fluid"></p>	
        	<?php echo montarLinkExporCarta(); ?>
    	</div>
		<?php
	// FINAL NPC ---------------------------------------------------------------------   
    } else {
    // INICIO JOGADOR HUMANO  --------------------------------------------------------   
        $suspeitos = listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO');
        $armas = listarCartaPeloTipo($CARTAS_BASE, 'ARMA');
        $locais = listarCartaPeloTipo($CARTAS_BASE, 'LOCAL');
        
        $etapa = ($_GET["acusar"])?"10":"9";
        
        echo exibirTexto('Selecine cada um dos tipos de cartas!');
        ?>
        </br>
        <div class="row">
        	<form action="./index.php" method="get" id="myForm" class="col-md-6 tabela">
    			<input type="hidden" name="etapa" value="<?php echo $etapa; ?>">
    			<div class="form-group">
    				<label for="suspeito" style="font-size: xx-large;">Suspeito</label> <select name="suspeito" id="suspeito" class="form-control form-control-lg">
                		<?php echo montarComboBoxPorLista($suspeitos); ?>
            		</select>
    			</div>
    			<div class="form-group">
    				<label for="arma" style="font-size: xx-large;">Arma</label> 
    				<select name="arma" id="arma" class="form-control form-control-lg">
    					<?php echo montarComboBoxPorLista($armas); ?>
    				</select>
    			</div>
    			<div class="form-group">
    				<label for="local" style="font-size: xx-large;">Local</label> 
    				<select name="local" id="local" class="form-control form-control-lg">
    					<?php echo montarComboBoxPorLista($locais); ?>
    				</select>
    			</div>
    			<div class="form-group">
    				<div class="row">
    				<?php 
    				    echo montarLinkFormulario('Confirmar!', 'col-md-6');
    				    echo montarLinkVoltar('col-md-6'); 
    			    ?>
        			</div>
        		</div>
    		</form>
		</div>
		<?php
		echo '</br>'.exibirTexto('Revise a sua Ficha de Palpites!', 'id="texto-ficha"').'</br>';
		echo exibirFichaPalpites($jogador["palpites"]);
	// FINAL JOGADOR HUMANO  --------------------------------------------------------  
    }
    
} else if ($_SESSION["etapa"] == "7") {//Essa etapa é reponsavel pela exposição das cartas que foi usada no palpite e que não é suspeito **************
    
    $aux = localizarProximoJogadorComCartaPalpite($_SESSION["posicao_jogador"], $_SESSION["jogadores"], $_SESSION["palpite"]);
    
    if($aux == null || count($aux["encontradas"]) == 0) {
        
        echo exibirTexto("Nenhuma carta foi localizada!");
        echo montarLinkProximaRodada();
    
    } else {

        $jogadorEncontrado = $aux["jogador"];
        $encontradas = $aux["encontradas"];
        
        //Esse embaralhamento é para escolher uma das cartas para incluir no palpite do jogador atual antes de trocar
        shuffle($encontradas);
        if ($jogadorEncontrado["npc"]) {
            
            // Apos o palpite se o proximo da vez for um NPC você deve ele escolhe uma das cartas selecionada e ja marca como descartadas
            $_SESSION["jogadores"] = atualizarPalpitesDosJogadores($_SESSION["jogadores"], $encontradas[0]);
            
            echo exibirTexto('A carta localizada do jogador, '.$jogadorEncontrado["nome"].' é:');
            
            ?><p><img width="400" src="./assets/imagens/<?php echo recuperarCaminhoImagem($encontradas[0]["tipo"], $encontradas[0]["imagem"]); ?>" class="img-fluid"></p><?php
    		echo montarLinkProximaRodada();
		
        } else {
            
            echo "<p><h1>Jogador Humano - " . $jogadorEncontrado["nome"] . ' selecione uma das cartas</h1></p>';
            $html = '<div class="col-md-12">';
            foreach ($encontradas as $encontrada) {
                $html .= '<a href="./index.php?etapa=8&carta='.$encontrada["codigo"].'"><img width="400" src="./assets/imagens/' . recuperarCaminhoImagem($encontrada["tipo"], $encontrada["imagem"]) . '" class="img-fluid" onclick="btnVibrate();"></a>';
            }
            $html .= '</div>';
            $html .= montarLinkVoltar();
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
    <?php
    echo montarLinkProximaRodada();
    
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
    
    echo exibirTexto('As cartas selecionadas pelo Jogador Humano foram:');
    ?>
    <p><img width="200" src="./assets/imagens/suspeitos/<?php echo $suspeito["imagem"]; ?>" class="img-fluid"></p>	
    <p><img width="200" src="./assets/imagens/armas/<?php echo $arma["imagem"]; ?>" class="img-fluid"></p>	
    <p><img width="200" src="./assets/imagens/locais/<?php echo $local["imagem"]; ?>" class="img-fluid"></p>	
    <?php
    echo montarLinkExporCarta();

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
                echo '<h1 style="text-align: center;"><a href="./index.php?etapa=6&acusar=true" onclick="btnVibrate();">Acusar!</a></h1>';
                
            } else {
               
                echo '<h1 style="text-align: center;">Infelizmente o NPC '.$jogador["nome"].', não conseguiu identificar o verdadeiro assassino, por conta disso ele acabou escapando!</h1>';
                echo '<p style="text-align: center;"><img width="200" src="./assets/imagens/suspeitos/'.$jogador["imagem"].'" class="img-fluid"></p>';
                echo montarLinkProximaRodada();
            
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
        ?><h1><a href="./index.php?etapa=0" onclick="btnVibrate();">Reiniciar</a></h1></br><?php 
    }

} else if($_SESSION["etapa"] == "11"){

    $_SESSION["jogadores"] = atualizarDestinoJogadorHumano($_SESSION["jogadores"], $_GET["local"] , $CARTAS_BASE);
    $voltar = ($_GET["voltar"]) ? '&voltar=true' : '';
    
    echo '<script>window.location.href = "./index.php?etapa=4'.$voltar.'";</script>';
    
} else if($_SESSION["etapa"] == "12") {
    
    $jogador = retornarJogadorHumano($_SESSION["jogadores"]);
    $locais = carregarProximosDestinosDisponiveis($CARTAS_BASE, $jogador);
    
    echo exibirTexto('Selecine seu proximo destino!');
?>
    </br>
    <div class="row">
    	<form action="./index.php" id="myForm" method="get" class="col-md-6 tabela" >
			<input type="hidden" name="etapa" value="11">
			<input type="hidden" name="voltar" value="true">
			<div class="form-group">
				<select name="local" id="local" class="form-control form-control-lg" style="font-size: xx-large;">
					<?php echo montarComboBoxPorLista($locais); ?>
				</select>
			</div>
			<div class="row">
			<?php 
			    echo montarLinkFormulario('Confirmar!', 'col-md-6');
			    echo montarLinkVoltar('col-md-6'); 
		    ?>
			</div>
		</form>
	</div>
<?php 
}
?>
</body>
<script type="text/javascript">

	function btnVibrate(){
		 navigator.vibrate(200);
	}
	
    var order = true;
	function slideUpAndDown(trigger, element, order ){
        $('#'+trigger).click(function(){
          if(order === true){
             $('#'+element).slideDown("slow");
          }else if(order === false){
             $('#'+element).slideUp("slow");
          }
          order = !order;
        });
    	return order;
    }
    
	$(document).ready(function() {
    	$('#ficha-palpite').hide();           	
        order = slideUpAndDown('texto-ficha', 'ficha-palpite', order );
	});   	

</script>
</html>