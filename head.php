<head>
<meta charset="UTF-8" />
<title>Detetive Solo</title>
<link rel="icon" href="./assets/imagens/favicon.png" type="image/png">
<link rel="stylesheet"
	href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
	integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
	crossorigin="anonymous">
<script src="./assets/js/jquery/jquery-3.3.1.min.js"></script>
<script
	src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
	integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
	crossorigin="anonymous"></script>
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
	integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
	crossorigin="anonymous"></script>
<script src="./assets/js/cronometro/cronometro.js"></script>
<style type="text/css">
.tipoFicha {
	background-color: green;
	color: white;
	text-align: center;
}

.imagem-com-borda {
    border: 2px solid transparent; /* Define uma borda transparente por padrão */
    transition: border-color 0.3s ease; /* Transição suave para a mudança de cor */
}

.imagem-com-borda:hover {
    border-color: white; /* Define a cor da borda (branca) ao passar o mouse */
}

.fichaMarcada {
	text-align: center;
	width: 30px;
	font-weight: bold;
}

.tabela {
	margin-left: auto;
	margin-right: auto;
}

.espacamentos {
	margin-top: 20px;
	margin-bottom: 20px;
}

.bg {
	/*background-image: url(./assets/imagens/detetive.png);*/
	background: rgba(76, 175, 80, 0.3);
}

.imagem-direita-superior {
	position: absolute;
	right: 0; /* Posiciona à direita do contêiner */
	top: 0; /* Posiciona no topo do contêiner */
	/* Ajuste as dimensões da imagem conforme necessário */
	width: 600px; /* Exemplo de largura */
	height: auto; /* Mantém as proporções */
	z-index: 1;
}

.imagem-esquerda-superior {
	position: absolute;
	left: 10px; /* Posiciona à direita do contêiner */
	top: 10px; /* Posiciona no topo do contêiner */
	/* Ajuste as dimensões da imagem conforme necessário */
	width: 80px; /* Exemplo de largura */
	height: auto; /* Mantém as proporções */
	z-index: 1;
	opacity: 30%;
}

.btn-ficha-palpite {
	position: absolute;
	right: 0; /* Posiciona à direita do contêiner */
	top: 0; /* Posiciona no topo do contêiner */
	/* Ajuste as dimensões da imagem conforme necessário */
	width: 80px; /* Exemplo de largura */
	height: auto; /* Mantém as proporções */
	z-index: 1;
	opacity: 30%;
}

.btn-modal-manual {
	position: absolute;
	left: 10px; /* Posiciona à direita do contêiner */
	top: 90px; /* Posiciona no topo do contêiner */
	/* Ajuste as dimensões da imagem conforme necessário */
	width: 80px; /* Exemplo de largura */
	height: auto; /* Mantém as proporções */
	z-index: 1;
	opacity: 30%;
}

.border-geral {
	border: 2px solid black;
	border-radius: 12px;
}

.botao-total-jogadores:hover {
	background-color: WHITE;
	border-radius: 70px;
}

.botao-geral:hover {
	background-color: WHITE;
	border-radius: 30px;
}

.botao-geral-desktop:hover {
	background-color: WHITE;
	border-radius: 50px;
}

.botao-reset:hover {
	background-color: WHITE;
	border-radius: 7px;
}

.botao-dados:hover {
	background-color: WHITE;
	border-radius: 38px;
}

.botao-dados-desktop:hover {
	background-color: WHITE;
	border-radius: 20px;
}

.botao-iniciar:hover {
	background-color: WHITE;
	border-radius: 100px;
}

.clock-container {
	display: inline-flex;
	align-items: center;
	gap: 20px; /* espaçamento entre relógio e botão */
}

.digital-clock {
	font-family: 'Courier New', monospace;
	font-size: 48px;
	color: #000; /* números em preto */
	background-color: transparent;
	padding: 20px 40px;
	border-radius: 12px;
	/*letter-spacing: 4px;*/
	border-radius: 12px;
	border: 2px solid #000;
}

.digital-clock-desktop {
	font-family: 'Courier New', monospace;
	font-size: 25px;
	color: #000; /* números em preto */
	background-color: transparent;
	padding: 20px 40px;
	border-radius: 12px;
	/*letter-spacing: 4px;*/
	border-radius: 12px;
	border: 2px solid #000;
}

.digital-clock span {
	display: inline-block;
	min-width: 40px;
	text-align: center;
	font: bold;
}

#pause-btn {
	font-size: 18px;
	padding: 12px 24px;
	border: 2px solid #000;
	background-color: transparent;
	color: #000;
	border-radius: 8px;
	cursor: pointer;
	transition: background-color 0.2s, color 0.2s;
}

#pause-btn:hover {
	background-color: #fff;
	color: #000;
}
</style>
</head>