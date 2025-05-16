<?php
if ($acao === 1) {
    
    echo exibirTexto('A carta localizada do jogador, '.$jogadorEncontrado["nome"].' é:');
    echo '<p><img width="400" src="./assets/imagens/'.recuperarCaminhoImagem($encontradas[0]["tipo"], $encontradas[0]["imagem"]).'" class="img-fluid"></p>';
    echo montarLinkProximaRodada();
    	
    } else if ($acao === 2) {
        
        echo "<p><h1>Jogador Humano - " . $jogadorEncontrado["nome"] . ' selecione uma das cartas</h1></p>';
        $html = '<div class="col-md-12">';
        foreach ($encontradas as $encontrada) {
            $html .= '<a href="./index.php?etapa=8&carta='.$encontrada["codigo"].'"><img width="400" src="./assets/imagens/' . recuperarCaminhoImagem($encontrada["tipo"], $encontrada["imagem"]) . '" class="img-fluid" onclick="btnVibrate();"></a>';
        }
        $html .= '</div>';
        $html .= montarLinkVoltar();
        echo $html;
        
    } else {
        echo exibirTexto("Nenhuma carta foi localizada!");
        echo montarLinkProximaRodada();
    }
?>