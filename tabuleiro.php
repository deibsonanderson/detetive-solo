<?php 



?>
<html>
<head>
	<link rel="stylesheet" href="estilo.css" type="text/css"/>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="montarTabuleiro.js"></script>
	<style>	
    	#tabuleiro{
        	width:1300px;
        	height:1300px;
        	border:solid 1px;
        }
        
        .linha{
        	height:50px;
        }
        
        .casa{
        	width:50px;
        	height:100%;
        	float:left;
        	cursor: pointer;
        	border: 1px solid black;
        }
        
        .casa_branca{
        	background-color: #fff;
        }
        
        .casa_preta{
        	background-color: #000;
        }
        
        .casa_selecionada{
        	background-color: #FF0000;
        }	
	</style>
</head>
<body>
	<div id="tabuleiro">
	</div>
	<div id="info">
		<ul>
			<li>Casa selecionada: <span id="info_casa_selecionada"/></li>
			<li>Peca selecionada: <span id="info_peca_selecionada"/></li>
		</ul>
	</div>
</body>
<script type="text/javascript">
    function montarTabuleiro(){
    	var i;
    	for (i=0; i<25; i++){
    		
    		$("#tabuleiro").append("<div id='linha_"+i.toString()+"' class='linha' >");
    
    		for (j=0; j<25; j++){
    		
    			var nome_casa = "casa_" + i.toString() + "_" + j.toString();
    			
    			var classe = ( i%2 == 0 ? (j%2 == 0 ? "casa_branca" : "casa_preta" ) : ( j%2 != 0 ? "casa_branca" : "casa_preta" ));
    			
    			$("#linha_" + i.toString() ).append("<div id='" + nome_casa + "' class='casa " + "casa_branca" + "' />");
    
                /*
    			if(classe == "casa_preta"){
    				if(i < 3){
    					$("#"+nome_casa).append("<img src='peca_preta.png' class='peca' id='"+nome_casa.replace("casa", "peca_preta")+"'/>");
    				}
    				else
    				if(i > 4){
    					$("#"+nome_casa).append("<img src='peca_branca.png' class='peca' id='"+nome_casa.replace("casa", "peca_branca")+"'/>");
    				}    
    			}
    			*/
    		}
    	}
    }
    
    $(function(){
        var casa_selecionada = null;
    	var peca_selecionada = null;
    	montarTabuleiro();

        $(".casa").click(function(){
        	$("#"+casa_selecionada).removeClass("casa_selecionada");
        	
        	casa_selecionada = $(this).attr("id");
        	
        	$("#"+casa_selecionada).addClass("casa_selecionada");
        	
        	$("#info_casa_selecionada").text(casa_selecionada);
        
        	peca_selecionada = $("#"+casa_selecionada).children("img:first").attr("id");
        	
        	if(peca_selecionada==null){
        		peca_selecionada = "NENHUMA PECA SELECIONADA";
        	}
        	
        	$("#info_peca_selecionada").text(peca_selecionada.toString());
        });

});
	
</script>
</html>