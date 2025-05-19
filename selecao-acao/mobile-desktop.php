<?php 
function montarTelaBotoesAcao($jogador, $total){
    $html = '<div class="row justify-content-center">';
    if ($jogador["npc"]) {
        $html .= ($total == 0) ? montarLinkRealizarPalpiteAcusacao(true, 'col-md-6') : montarLinkRealizarPalpiteAcusacao(false, 'col-md-6');
        $html .= montarLinkVoltar('col-md-6');
    } else {
        $html .= montarLinkRealizarPalpiteAcusacao(false, 'col-md-4');
        $html .= montarLinkRealizarPalpiteAcusacao(true, 'col-md-4');
        $html .= montarLinkVoltar('col-md-4');
    }
    return $html.'</div>';
}

function montarTelaFichaPalpites($jogador, $layout){
    $html = '';
    if (! $jogador["npc"]) {
        // $html .= '</br>'.exibirTexto('Revise a sua Ficha de Palpites!', '1', 'id="texto-ficha" style="cursor:pointer"').'</br>';
        $html .= ($layout == 'mobile') ? exibirFichaPalpites($jogador["palpites"]) : exibirFichaPalpitesHorizontal($jogador["palpites"]);
    }
    return $html;
}

if ($_SESSION["layout"] == 'mobile') {
    echo exibirTexto($jogador["nome"]);
    echo '<p><img width="200" src="./assets/imagens/suspeitos/'.$jogador["imagem"].'" class="img-fluid border-geral"></p>';
    echo '<div class="row justify-content-center">';
    echo montarTelaBotoesAcao($jogador, $total);
    echo '</div>';
    echo montarTelaFichaPalpites($jogador, $_SESSION["layout"]);
} else {
?>
<div class="row col-md-12 justify-content-center" >
	<div class="col-md-3 justify-content-center" >
		<div class="row col-md-12 espacamentos">
    		<img width="200" src="./assets/imagens/suspeitos/<?php echo $jogador["imagem"].'.'; ?>" class="img-fluid border-geral">
		</div>   
	</div>
	<div class="col-md-6 " >
		<div class="row col-md-12 espacamentos border-geral">
			<h1><?php echo $jogador["nome"].'.'; ?></h1>    		
		</div>
		<div class="row col-md-12 justify-content-center espacamentos">
			<?php echo montarTelaBotoesAcao($jogador, $total); ?>
		</div> 
	</div>
</div>
<div class="row col-md-12 justify-content-center" >
<?php echo montarTelaFichaPalpites($jogador, $_SESSION["layout"]); ?>
</div>
<?php 
}
?>