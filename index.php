<?php
require_once 'funcoes.php';
error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED & ~ E_WARNING);
?>
<!DOCTYPE html>
<html>
<?php require_once 'head.php'; ?>
<body class="bg">
	<img id="jogar-dados" src="./assets/imagens/jogar_dados.gif" class="imagem-direita-superior" style="display: none;">
	<div class="container" style="text-align: center; ">
    <?php
    if (!isset($_SESSION["etapa"]) || $_SESSION["etapa"] == "0") {
        
        // Selecionar se interface se é mobile ou desktop
        echo '<div class="row espacamentos justify-content-center">';
        echo montarLinkImagem('./index.php?etapa=13&layout=mobile', 'Mobile', 'col-md-4', 'mobile.png', '200');
        echo montarLinkImagem('./index.php?etapa=14', 'Manual', 'col-md-4', 'livro.png', '200', 'target="_blank"');
        echo montarLinkImagem('./index.php?etapa=13&layout=desktop', 'Desktop', 'col-md-4', 'computador-borda.png', '200');
        echo '</div>';
        
    } else if ($_SESSION["etapa"] == "1") {
        
        // Selecionar um personagem 
        require_once './selecao-personagens/controle.php';
        require_once './selecao-personagens/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "2") {
        
        // Selecione a quantidade de dados & SETUP 
        require_once './inicializacao/controle.php';
        require_once './inicializacao/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "3") {
        
        // Exibir cartas do jogador, definir a ordem dos participantes, 
        require_once './cartas-iniciais/controle.php';
        require_once './cartas-iniciais/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "4") {
        
        // A funcção dessa etapa é navegar entre os jogadores e disponibiizar os botões para realizar alguma ação.
        require_once './rodadas/controle.php';
        require_once './rodadas/'.$_SESSION["layout"].'.php';
        
    } else if ($_SESSION["etapa"] == "5") {
        
        // Essa etapa so tem a função de listar as ações que serão escolhidas!!!! 
        require_once './selecao-acao/controle.php';
        require_once './selecao-acao/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "6") {
        
        // Essa etapa tem a função de expor as cartas que o NPC fez os palpites
        // Essa etapa tem a função selecionar as cartas dos palpites do jogador humano
        require_once './selecao-carta-palpite-acusacao/controle.php';
        require_once './selecao-carta-palpite-acusacao/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "7") {
        
        // Essa etapa é reponsavel pela exposição de umas das cartas que foi usada no palpite e que não é suspeito
        // Ela localiza o proximo participante que possue uma ou mais das cartas usada no palpite
        // Durante a localização se o escolhido for uma NPC ja sorteia e exibe uma das cartas para anotamos na nossa ficha!
        // Durante a localização se o escolhido for uma Humano disponibiza para selecionar uma das cartas caso assim tenha redirecionando para a expor na etapa (8)
        require_once './selecao-exposicao-carta-jogador/controle.php';
        require_once './selecao-exposicao-carta-jogador/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "8") {
        
        // Essa etapa é exclusiva do jogador humano para que possa escolher uma das cartas informada no palpite 
        require_once './exposicao-carta-jogador/controle.php';
        require_once './exposicao-carta-jogador/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "9") {
        
        // Essa etapa é responsavel pela exibição dos palpites realizados pelo jogador humano na etapa anteiror (6)
        require_once './exibicao-palpite-jogador/controle.php';
        require_once './exibicao-palpite-jogador/mobile-desktop.php';
        
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
        require_once './numero-jogadores/mobile-desktop.php';
        
    } else if ($_SESSION["etapa"] == "14") {
    
        
        for ($i = 1; $i <= 4; $i++) {
            ?>
            <div class="row col-md-12 justify-content-center espacamentos" >
        		<div class="row col-md-12 justify-content-center espacamentos">
            		<img src="./assets/imagens/manual/<?php echo $i; ?>.png" class="img-fluid border-geral">
        		</div>   
        	</div>    
            <?php 
        }    
        
    }
    
    if ($_SESSION["etapa"] > 0){        
        echo exibirTipoJogador($_SESSION["jogadores"], $_SESSION["posicao_jogador"]);
        echo montarLinkReset();        
        if($_SESSION["etapa"] > 4 && $_SESSION["etapa"] < 13){
            echo montarModalFichaPalpite($_SESSION["jogadores"]);
            
        }
        echo montarModalManual();
    }
    ?>
    

    
</body>
<?php echo exporScriptJs(true); ?>
</html>