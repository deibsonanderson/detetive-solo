<meta charset="UTF-8" />
<title>Document</title>
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

.fichaMarcada {
	text-align: center;
	width: 30px;
	font-weight: bold;
}

.tabela {
	margin-left: auto;
	margin-right: auto;
}

.bg {
	/*background-image: url(./assets/imagens/detetive.png);*/
	background: rgba(76, 175, 80, 0.3);
}

.imagem-direita {
  position: absolute;
  right: 0; /* Posiciona à direita do contêiner */
  top: 0; /* Posiciona no topo do contêiner */
  /* Ajuste as dimensões da imagem conforme necessário */
  width: 600px; /* Exemplo de largura */
  height: auto; /* Mantém as proporções */
}

/*
.clock-container {
  display: flex;
  align-items: center;
  gap: 20px;
}

.digital-clock {
  font-family: 'Courier New', monospace;
  font-size: 48px;
  color: #00ffcc;
  background-color: #000;
  padding: 20px 40px;
  border-radius: 12px;
  display: inline-block;
  box-shadow: 0 0 20px #00ffcc;
  letter-spacing: 4px;
}

.digital-clock span {
  display: inline-block;
  min-width: 40px;
  text-align: center;
}

#pause-btn {
  font-size: 18px;
  padding: 12px 24px;
  border: 2px solid #00ffcc;
  background-color: #000;
  color: #00ffcc;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.2s, color 0.2s, box-shadow 0.2s;
  box-shadow: 0 0 10px #00ffcc;
}

#pause-btn:hover {
  background-color: #00ffcc;
  color: #000;
}
*/

.botao-total-jogadores:hover {
  background-color: WHITE;
  border-radius: 70px; /* Cor de fundo quando o mouse estiver sobre o botão */
}

.botao-dados:hover {
  background-color: WHITE;
  border-radius: 38px; /* Cor de fundo quando o mouse estiver sobre o botão */
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
  letter-spacing: 4px;
  border-radius: 12px;
  border: 2px solid #000;
}

.digital-clock span {
  display: inline-block;
  min-width: 40px;
  text-align: center;
  font:bold;
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
  background-color: #000;
  color: #fff;
}
</style>