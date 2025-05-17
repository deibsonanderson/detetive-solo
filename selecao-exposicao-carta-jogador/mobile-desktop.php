<?php
function montarTelaSelecaoExposicaoCarta($acao, $jogadorEncontrado, $encontradas, $width = '400'){
    if ($acao === 1) {
        $html = exibirTexto('A carta localizada do jogador, ' . $jogadorEncontrado["nome"] . ' é:');
        $html .= '<p><img width="'.$width.'" src="./assets/imagens/' . recuperarCaminhoImagem($encontradas[0]["tipo"], $encontradas[0]["imagem"]) . '" class="img-fluid border-geral"></p>';
        $html .= montarLinkProximaRodada();
    } else if ($acao === 2) {
        $html =  '<p>'.exibirTexto('Jogador Humano, ' . $jogadorEncontrado["nome"] . ' selecione uma das cartas').'</p>';
        $html .= '<div class="col-md-12">';
        foreach ($encontradas as $encontrada) {
            $html .= '<a href="./index.php?etapa=8&carta=' . $encontrada["codigo"] . '">
                         <img width="'.$width.'" src="./assets/imagens/' . recuperarCaminhoImagem($encontrada["tipo"], $encontrada["imagem"]) . '" class="img-fluid border-geral" onclick="btnVibrate();">
                      </a>';
        }
        $html .= '</div>';
        $html .= montarLinkVoltar();        
    } else {
        $html = exibirTexto("Nenhuma carta foi localizada!");
        $html .= montarLinkProximaRodada();
    }
    return $html;
}

function montarTelaSelecaoExposicaoCartaDesktop($acao, $jogadorEncontrado, $encontradas, $width = '400'){
    if ($acao === 1) {
        ?>
    	<div class="row justify-content-center" >
        	<div class="col-md-4 justify-content-center" >
        		<div class="row col-md-12 espacamentos justify-content-center">
    	    		<img width="150" src="./assets/imagens/suspeitos/<?php echo $jogadorEncontrado["imagem"].'.'; ?>" class="img-fluid border-geral">
        		</div>   
        		<div class="row col-md-12 espacamentos justify-content-center">
    	    		<img width="100" src="./assets/imagens/<?php echo ($jogadorEncontrado["npc"])? 'computador.png' : 'humano.png'; ?>" class="img-fluid border-geral">
        		</div> 
    		</div>
    		<div class="col-md-8" >
        		<div class="row col-md-12 espacamentos justify-content-center border-geral">
        			<?php echo exibirTexto($jogadorEncontrado["nome"]); ?>    		
        		</div>
        		<div class="row col-md-12 espacamentos justify-content-center border-geral" style="padding-left:0px">
    				<?php echo exibirTexto('Possui a cartar abaixo:', '2'); ?>    		
        		</div>    		
        		<div class="row col-md-12 justify-content-center espacamentos">
        			<?php echo '<img width="'.$width.'" src="./assets/imagens/' . recuperarCaminhoImagem($encontradas[0]["tipo"], $encontradas[0]["imagem"]) . '" class="img-fluid border-geral">'; ?>    		
        		</div>
        		<div class="row col-md-12 justify-content-center espacamentos">
        			<?php echo montarLinkProximaRodada(); ?>    		
        		</div> 
    		</div>		
    	</div>
        <?php 
    } else if ($acao === 2) {
        $html =  '<p>'.exibirTexto('Jogador Humano, ' . $jogadorEncontrado["nome"] . ' selecione uma das cartas').'</p>';
        $html .= '<div class="col-md-12">';
        foreach ($encontradas as $encontrada) {
            $html .= '<a href="./index.php?etapa=8&carta=' . $encontrada["codigo"] . '">
                         <img width="'.$width.'" src="./assets/imagens/' . recuperarCaminhoImagem($encontrada["tipo"], $encontrada["imagem"]) . '" class="img-fluid border-geral" onclick="btnVibrate();">
                      </a>';
        }
        $html .= '</div>';
        $html .= montarLinkVoltar(' col-md-12 espacamentos ');
        return $html;
    }else{
        echo exibirTexto("Nenhuma carta foi localizada!");
        echo montarLinkProximaRodada();
    }
}

if ($_SESSION["layout"] == 'mobile') {
    echo montarTelaSelecaoExposicaoCarta($acao, $jogadorEncontrado, $encontradas);
} else {
    echo montarTelaSelecaoExposicaoCartaDesktop($acao, $jogadorEncontrado, $encontradas, '150');
    //echo montarTelaSelecaoExposicaoCarta($acao, $jogadorEncontrado, $encontradas);
}
?>