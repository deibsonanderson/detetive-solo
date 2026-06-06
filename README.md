# Documentação de Especificação Técnica - Detetive Solo

Esta documentação descreve a arquitetura, o fluxo de controle, os modelos de dados e as mecânicas de jogo do projeto **Detetive Solo**, um jogo web em PHP baseado no clássico jogo de tabuleiro *Detetive* (Clue), projetado para ser jogado de forma solo contra oponentes controlados por computador (NPCs).

---

## 1. Visão Geral do Projeto

O **Detetive Solo** é uma aplicação web monolítica escrita em **PHP** e baseada em sessões (`$_SESSION`), utilizando **Bootstrap 4** e **jQuery** no frontend. O objetivo principal do jogo é simular a dinâmica de investigação do clássico *Detetive*.

### Principais Características:
* **Modo de Jogo:** Solo (1 jogador humano vs. 1 a 5 NPCs).
* **Persistência de Estado:** Todo o progresso da partida é mantido em memória via `session_start()` do PHP, sem necessidade de banco de dados.
* **Interface Responsiva:** Suporte a layouts distintos para **Mobile** e **Desktop**, selecionável logo no início.
* **Componentes Gráficos:** Utilização intensiva de imagens para cartas (armas, suspeitos, locais) e pinos coloridos de identificação.
* **Temporizador integrado:** Controle de tempo por rodada que força o avanço ou recarregamento automático da jogada.

---

## 2. Arquitetura e Fluxo do Jogo

O ciclo de vida do jogo é gerenciado por uma máquina de estados simples orientada pela variável de sessão `$_SESSION["etapa"]`. A navegação e roteamento concentram-se no arquivo [index.php](file:///D:/xampp/htdocs/detetive-solo/index.php).

### Tabela de Etapas (`$_SESSION["etapa"]`)

| Código da Etapa | Nome da Etapa | Descrição |
| :---: | :--- | :--- |
| **1** | Menu Inicial / Landing | Destrói a sessão anterior. Permite selecionar o layout (**Mobile** ou **Desktop**) ou acessar o Manual do Jogo. |
| **2** | Quantidade de Jogadores | Permite escolher de 2 a 6 participantes (1 Humano + NPCs). |
| **3** | Escolha de Personagem | Apresenta a lista de suspeitos disponíveis para o jogador escolher o seu investigador. |
| **4** | Escolha de Dados / Setup | O jogador escolhe a quantidade de dados (1 a 3). Inicializa o crime, cria os NPCs, distribui as cartas e gera as fichas de palpites. |
| **5** | Tela de Cartas Iniciais | Mostra as cartas distribuídas ao jogador humano e define o seu ponto de partida e o temporizador de rodada. |
| **6** | Atualização de Destino (Invisível) | Script controlador para atualizar o destino atual do jogador humano sem exibir tela própria. Redireciona para a rodada. |
| **7** | Rodada de Movimentação | Efetua o sorteio dos dados para movimentação e inicia o cronômetro. Roda o turno do jogador correspondente (Humano ou NPC). |
| **8** | Seleção de Ação | Exibe as opções de ações disponíveis para quem chegou ao destino: *Realizar Palpite*, *Acusar* ou *Voltar*. |
| **9** | Seleção de Palpite / Acusação | O jogador escolhe o Suspeito, a Arma e o Local (se acusando) do palpite/acusação. Para NPCs, essa seleção é automática. |
| **10** | Confirmação de Palpite (Humano) | Exibe as cartas selecionadas no palpite do jogador humano para confirmação antes de partir para a revelação. |
| **11** | Processamento do Palpite | Identifica quem é o próximo jogador na ordem que possui alguma das cartas do palpite para expô-la. Se for NPC, sorteia uma carta elegível e atualiza as fichas. |
| **12** | Exposição de Carta pelo Humano | Tela na qual o jogador humano deve selecionar qual de suas cartas do palpite irá revelar para os outros oponentes. |
| **13** | Desfecho da Acusação | Avalia se a acusação confere com o crime gerado no início. Define vitória do jogador/NPC ou a eliminação do acusador. |
| **14** | Mudança Manual de Destino | Permite ao jogador humano escolher manualmente um local vizinho/disponível no mapa para se deslocar. |
| **15** | Manual do Jogo | Exibe as telas estáticas do manual do jogo para instruções detalhadas das regras. |

---

## 3. Estrutura de Arquivos

O projeto está estruturado em diretórios com base em responsabilidades e componentes do jogo:

* **Arquivos Raiz:**
  * [index.php](file:///D:/xampp/htdocs/detetive-solo/index.php): Arquivo principal de roteamento de etapas e renderização do contêiner HTML.
  * [funcoes.php](file:///D:/xampp/htdocs/detetive-solo/funcoes.php): Contém a lógica de negócios, utilitários, tratamento de listas de cartas, distribuição de cartas e renderização HTML dinâmica.
  * [cartas.php](file:///D:/xampp/htdocs/detetive-solo/cartas.php): Armazena a constante global `$CARTAS_BASE`, que contém o cadastro estático de todas as cartas.
  * [head.php](file:///D:/xampp/htdocs/detetive-solo/head.php): Contém as metatags, links para folhas de estilo, JavaScripts e regras de CSS compartilhadas do jogo.
  * [tabuleiro.php](file:///D:/xampp/htdocs/detetive-solo/tabuleiro.php): Protótipo experimental de tabuleiro quadriculado interativo com jQuery (não integrado no fluxo principal).

* **Módulos das Etapas (Diretórios de Recursos):**
  Cada pasta a seguir contém scripts específicos de fluxo e interface gráfica (divisão lógica de controle e visualização):
  * **`numero-jogadores/`**: [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/numero-jogadores/mobile-desktop.php) (etapa 2).
  * **`selecao-personagens/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/selecao-personagens/controle.php) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/selecao-personagens/mobile-desktop.php) (etapa 3).
  * **`inicializacao/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/inicializacao/controle.php) (etapa 4) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/inicializacao/mobile-desktop.php).
  * **`cartas-iniciais/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/cartas-iniciais/controle.php) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/cartas-iniciais/mobile-desktop.php) (etapa 5).
  * **`atualizar-destino/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/atualizar-destino/controle.php) (etapa 6).
  * **`rodadas/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/rodadas/controle.php), [mobile.php](file:///D:/xampp/htdocs/detetive-solo/rodadas/mobile.php) e [desktop.php](file:///D:/xampp/htdocs/detetive-solo/rodadas/desktop.php) (etapa 7).
  * **`selecao-acao/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/selecao-acao/controle.php) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/selecao-acao/mobile-desktop.php) (etapa 8).
  * **`selecao-carta-palpite-acusacao/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/selecao-carta-palpite-acusacao/controle.php) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/selecao-carta-palpite-acusacao/mobile-desktop.php) (etapa 9).
  * **`exibicao-palpite-jogador/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/exibicao-palpite-jogador/controle.php) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/exibicao-palpite-jogador/mobile-desktop.php) (etapa 10).
  * **`selecao-exposicao-carta-jogador/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/selecao-exposicao-carta-jogador/controle.php) e [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/selecao-exposicao-carta-jogador/mobile-desktop.php) (etapa 11).
  * **`exposicao-carta-jogador/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/exposicao-carta-jogador/controle.php) and [mobile-desktop.php](file:///D:/xampp/htdocs/detetive-solo/exposicao-carta-jogador/mobile-desktop.php) (etapa 12).
  * **`desfecho-acusacao/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/desfecho-acusacao/controle.php) e [mobile.php](file:///D:/xampp/htdocs/detetive-solo/desfecho-acusacao/mobile.php) (etapa 13).
  * **`selecao-destino/`**: [controle.php](file:///D:/xampp/htdocs/detetive-solo/selecao-destino/controle.php) e [mobile.php](file:///D:/xampp/htdocs/detetive-solo/selecao-destino/mobile.php) (etapa 14).

* **Recursos Estáticos (`assets/`):**
  * CSS: Bootstrap 4 local.
  * JS: Bootstrap 4, Popper.js, jQuery 3.3.1 e [cronometro.js](file:///D:/xampp/htdocs/detetive-solo/assets/js/cronometro/cronometro.js).
  * Imagens: Favicon, ícones de controle, animação de dados jogando, imagens individuais de armas (50 a 57), suspeitos (70 a 77), locais (89 a 99) e manuais.

---

## 4. Modelagem de Dados

### 4.1 Cadastro de Cartas (`$CARTAS_BASE`)
Todas as cartas disponíveis no jogo são declaradas no array `$CARTAS_BASE` no arquivo [cartas.php](file:///D:/xampp/htdocs/detetive-solo/cartas.php). Elas são categorizadas em três tipos principais:

* **ARMA:**
  * Curingas identificadores de 50 a 57.
  * *Exemplos:* Veneno, Faca, Espingarda, Arma Química, Pá, Pé de Cabra, Soco Inglês, Tesoura.
* **SUSPEITO:**
  * Curingas identificadores de 70 a 77.
  * Inclui configuração de pino (`pinu`), local de início padrão (`local`) e nome do personagem.
  * *Exemplos:* Advogado - Sr. Marinho, Sargento - Bigode, Mordomo - James, Médica - Dona Violeta, Dançarina - Srta. Rosa, Florista - Dona Branca, Chef de Cozinha - Tony Gourmet, Coveiro - Sergio Saturno.
* **LOCAL:**
  * Curingas identificadores de 89 a 99.
  * *Exemplos:* Prefeitura, Mansão, Banco, Boate, Estação de Trem, Restaurante, Praça Central, Hotel, Hospital, Floricultura, Cemitério.

### 4.2 Estrutura da Sessão (`$_SESSION`)
A sessão gerencia todo o estado da partida:

```php
$_SESSION = [
    "etapa" => "7",                     // Estado atual do jogo (redirecionamento)
    "layout" => "desktop",              // Layout de tela escolhido ('mobile' ou 'desktop')
    "qtd_dados" => 2,                   // Quantidade de dados selecionada para o jogo
    "tempo" => 14,                      // Tempo limite por rodada em segundos (-1 do valor total)
    "numero_participante" => 4,          // Quantidade total de jogadores selecionados
    "jogador" => 71,                    // Código do personagem escolhido pelo Humano
    "posicao_jogador" => 1,             // Índice do jogador do turno no array $_SESSION["jogadores"]
    
    // O Segredo do Crime (Sorteado no setup)
    "criminoso" => [
        "suspeito" => [ "codigo" => 75, "nome" => "Florista...", "tipo" => "SUSPEITO", ... ],
        "arma"     => [ "codigo" => 53, "nome" => "Arma Quimica", "tipo" => "ARMA", ... ],
        "local"    => [ "codigo" => 90, "nome" => "Mansão", "tipo" => "LOCAL", ... ]
    ],
    
    // Lista de Jogadores da partida (Humano e NPCs)
    "jogadores" => [
        [
            "codigo" => 71,
            "nome" => "Sargento - Bigode",
            "tipo" => "SUSPEITO",
            "pinu" => "AMARELO",
            "npc" => false,              // Flag que diferencia o Humano de NPCs
            "cartas" => [ ... ],        // Cartas na mão do jogador (não fazem parte do crime)
            "destinoAtual" => [ ... ],  // Próximo local para onde o peão está indo/está
            "palpites" => [             // Ficha de deduções individual (X para o que sabe que não é, O para o crime se debug ligado)
                "SUSPEITO" => [ ... ],
                "ARMA" => [ ... ],
                "LOCAL" => [ ... ]
            ]
        ],
        // ... Outros jogadores (NPCs)
    ],
    
    // Armazena o palpite ativo que está sendo contestado no fluxo atual
    "palpite" => [
        "suspeito" => [ ... ],
        "arma" => [ ... ],
        "local" => [ ... ]
    ]
];
```

---

## 5. Regras e Mecânicas de Jogo Traduzidas para Código

### 5.1 O Crime e Distribuição de Cartas
Ao inicializar o jogo na etapa 4 ([inicializacao/controle.php](file:///D:/xampp/htdocs/detetive-solo/inicializacao/controle.php)):
1. O sistema sorteia aleatoriamente uma carta de cada categoria (Suspeito, Arma, Local) chamando a função [montarCriminoso](file:///D:/xampp/htdocs/detetive-solo/funcoes.php#L231-L243). Estas cartas formam a acusação correta (`$_SESSION["criminoso"]`) e são guardadas sob sigilo.
2. Todas as cartas restantes são distribuídas de forma cíclica e uniforme entre os jogadores participantes (incluindo NPCs) usando a função [distribuirCartasParaParticipantes](file:///D:/xampp/htdocs/detetive-solo/funcoes.php#L245-L270).

### 5.2 Rotação de Turnos (Rounds)
O controle de turnos na etapa 7 ([rodadas/controle.php](file:///D:/xampp/htdocs/detetive-solo/rodadas/controle.php)) avança incrementando a `$_SESSION["posicao_jogador"]` por meio da função `proximaPosicaoJogador()`.
* **Se o jogador atual for Humano:** Ele visualiza a tela com a contagem de dados jogados, o cronômetro correndo e tem botões para:
  * *Cheguei no local:* Se mover e fazer um palpite ou acusação.
  * *Atualizar Destino:* Modificar para qual sala deseja se deslocar.
  * *Próxima Rodada:* Passar a vez.
* **Se o jogador atual for NPC:** Ele joga de forma automatizada. A rodada dele dura o tempo programado no cronômetro. Seus palpites e movimentos são gerados automaticamente. O jogador humano apenas acompanha a contagem e clica no avanço ou aguarda o cronômetro para passar a vez.

### 5.3 O Palpite e Contestações (Descarte de Cartas)
Quando um jogador chega a um local (etapa 8), ele faz um palpite com um Suspeito, uma Arma e o Local onde se encontra.
* **Busca por Contestador:** A função [localizarProximoJogadorComCartaPalpite](file:///D:/xampp/htdocs/detetive-solo/funcoes.php#L565-L587) varre os jogadores seguintes na ordem horária. O primeiro jogador encontrado que possui pelo menos uma das cartas do palpite é definido como o revelador.
* **Exposição automática de NPCs:** Se o jogador que possui a carta for um NPC, o sistema seleciona aleatoriamente um das cartas correspondentes que ele possui, exibe na tela para o jogador humano e atualiza automaticamente a ficha de palpites (`marcado = 1`), descartando essa possibilidade para a investigação.
* **Exposição do Humano:** Se o jogador contestador for o Humano, o sistema redireciona para a etapa 12 ([exposicao-carta-jogador/controle.php](file:///D:/xampp/htdocs/detetive-solo/exposicao-carta-jogador/controle.php)) obrigando o jogador humano a escolher qual carta do palpite do oponente quer mostrar ao grupo.

### 5.4 A Acusação Final e Eliminação
Ao escolher fazer uma **Acusação** (etapa 13):
* O sistema compara as 3 cartas selecionadas com o segredo guardado em `$_SESSION["criminoso"]`.
* **Sucesso:** O jogo acaba e exibe uma tela de vitória para o jogador humano ou uma derrota informando que o NPC solucionou o mistério.
* **Falha:**
  * Se foi o **Jogador Humano** que errou, o jogo é encerrado imediatamente com tela de "Game Over" (Derrota).
  * Se foi um **NPC** que errou, este é permanentemente removido da lista de jogadores (`$_SESSION["jogadores"]`) chamando [removerJogador](file:///D:/xampp/htdocs/detetive-solo/funcoes.php#L555-L563), e a partida prossegue com os investigadores restantes.

---

## 6. Lógica de Inteligência Artificial Simplificada (NPCs)

Os NPCs tomam decisões autônomas baseadas no estado da sua ficha de palpites individual:
1. **Movimentação / Escolha de Destinos:** Os NPCs escolhem o seu próximo local de forma aleatória entre os locais disponíveis que não possuam na própria mão e que não seja o seu local atual (função `carregarProximoDestino`).
2. **Seleção de Palpites:** Ao chegar em um local, o NPC busca em sua ficha de palpites quais cartas de *Suspeito* e *Arma* ainda estão desmarcadas (`marcado == 0`). O sistema embaralha e seleciona a primeira disponível. O local do palpite é fixado na sala atual dele.
3. **Acusação:** O NPC só realiza uma acusação oficial (etapa 13) se todas as cartas de sua ficha de palpites já tiverem sido elucidadas (ou seja, se restarem exatamente 3 cartas desmarcadas na ficha, que correspondem ao assassino, arma e local corretos).

---

## 7. Oportunidades de Refatoração e Melhorias

Após análise profunda do código-fonte, foram identificados alguns aspectos que podem ser aprimorados em futuras versões do sistema:

1. **Uso de Tabuleiro Interativo:** O arquivo [tabuleiro.php](file:///D:/xampp/htdocs/detetive-solo/tabuleiro.php) e os scripts relacionados estão isolados e desativados. Atualmente a locomoção é meramente conceitual (seleção de nome do local via lista suspensa). Integrar um tabuleiro quadriculado interativo com colisão e caminhos enriqueceria a jogabilidade.
2. **Segurança dos Dados:** Como os segredos do crime estão armazenados na sessão de forma limpa, um usuário com conhecimentos básicos em ferramentas de desenvolvedor ou manipulação de cookie/sessão pode obter a resposta do crime consultando o estado do PHP ou ativando a exibição de debug injetada no código HTML.
3. **Dependências Externas:** O arquivo [head.php](file:///D:/xampp/htdocs/detetive-solo/head.php) importa o Bootstrap CSS e JavaScript de uma CDN com links de integridade, mas também possui arquivos locais na pasta `/assets/js/jquery/`. Seria ideal uniformizar essas dependências.
4. **Acoplamento de View e Controller:** Muitas páginas de fluxo efetuam redirecionamentos HTML com `echo '<script>window.location.href = ...</script>'` de dentro da renderização da view. O ideal seria centralizar a lógica de transição de estado no início da requisição, antes de enviar qualquer caractere de renderização ao navegador.
