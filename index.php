<?php
require_once 'funcoes.php';
error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED & ~ E_WARNING);
?>
<!DOCTYPE html>
<html>
<?php require_once 'head.php'; ?>
<body class="bg">
	<img id="jogar-dados" src="./assets/imagens/jogar_dados.gif" class="imagem-direita" style="display: none; z-index: 1;">
	<div class="container" style="text-align: center; ">
    <?php
    if (!isset($_SESSION["etapa"]) || $_SESSION["etapa"] == "0") {
        
        // Selecionar a quantidade de jogadores 
        //require_once './numero-jogadores/mobile.php';
        echo '<div class="row espacamentos justify-content-center">';
        echo montarLinkInicial('./index.php?etapa=13&layout=mobile', 'Mobile', 'col-md-4', true, 'mobile.png', '400');
        echo montarLinkInicial('./index.php?etapa=13&layout=desktop', 'Desktop', 'col-md-4', true, 'computador-borda.png', '400');
        echo '</div>';
        
    } else if ($_SESSION["etapa"] == "1") {
        
        // Selecionar um personagem 
        require_once './selecao-personagens/controle.php';
        require_once './selecao-personagens/mobile.php';
        
    } else if ($_SESSION["etapa"] == "2") {
        
        // Selecione a quantidade de dados & SETUP 
        require_once './inicializacao/controle.php';
        require_once './inicializacao/mobile.php';
        
    } else if ($_SESSION["etapa"] == "3") {
        
        // Exibir cartas do jogador, definir a ordem dos participantes, 
        require_once './cartas-iniciais/controle.php';
        require_once './cartas-iniciais/mobile.php';
        
    } else if ($_SESSION["etapa"] == "4") {
        
        // A funcção dessa etapa é navegar entre os jogadores e disponibiizar os botões para realizar alguma ação.
        require_once './rodadas/controle.php';
        require_once './rodadas/'.$_SESSION["layout"].'.php';
        
    } else if ($_SESSION["etapa"] == "5") {
        
        // Essa etapa so tem a função de listar as ações que serão escolhidas!!!! 
        require_once './selecao-acao/controle.php';
        require_once './selecao-acao/mobile.php';
        
    } else if ($_SESSION["etapa"] == "6") {
        
        // Essa etapa tem a função de expor as cartas que o NPC fez os palpites 
        require_once './selecao-carta-palpite-acusacao/controle.php';
        require_once './selecao-carta-palpite-acusacao/mobile.php';
        
    } else if ($_SESSION["etapa"] == "7") {
        
        // Essa etapa é reponsavel pela exposição das cartas que foi usada no palpite e que não é suspeito 
        require_once './selecao-exposicao-carta-jogador/controle.php';
        require_once './selecao-exposicao-carta-jogador/mobile.php';
        
    } else if ($_SESSION["etapa"] == "8") {
        
        // Essa etapa é exlusiva do jogador humano para que possa escolher uma das cartas informada no palpite 
        require_once './exposicao-carta-jogador/controle.php';
        require_once './exposicao-carta-jogador/mobile.php';
        
    } else if ($_SESSION["etapa"] == "9") {
        
        // Essa etapa é responsavel pela exibição dos palpites realizados pelo jogador humano
        require_once './exibicao-palpite-jogador/controle.php';
        require_once './exibicao-palpite-jogador/mobile.php';
        
    } else if ($_SESSION["etapa"] == "10") {
        
        // Essa etapa é responsavel pela desfecho da acusação se foi com sucesso ou falha 
        require_once './desfecho-acusacao/controle.php';
        require_once './desfecho-acusacao/mobile.php';
        
    } else if ($_SESSION["etapa"] == "11") {

        require_once './atualizar-destino/controle.php';
        
    } else if ($_SESSION["etapa"] == "12") {

        require_once './selecao-destino/controle.php';
        require_once './selecao-destino/mobile.php';
        
    } else if ($_SESSION["etapa"] == "13") {
        
        // Selecionar a quantidade de jogadores
        $_SESSION["layout"] = $_GET["layout"];
        require_once './numero-jogadores/mobile.php';
        
    }
    
    if($_SESSION["etapa"] > 0){
        echo montarLinkReset();
    }
    
    ?>
</body>
<?php echo exporScriptJs(true); ?>
</html>