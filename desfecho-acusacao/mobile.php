<?php 
if($jogador["npc"]){
    
    if($sucesso){
        
        echo '<h1 style="text-align: center;">Infelizmente você não conseguiu identificar o verdadeiro assassino, o jogador '.$jogador["nome"].' é o verdadeiro DETETIVE!</h1>';
        echo '<p style="text-align: center;"><img width="200" src="./assets/imagens/game_over.png" class="img-fluid"></p>';
        
    } else {
        
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
?>