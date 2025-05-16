<?php
    $_SESSION["jogadores"] = atualizarDestinoJogadorHumano($_SESSION["jogadores"], $_GET["local"] , $CARTAS_BASE);
    $voltar = ($_GET["voltar"]) ? '&voltar=true' : '';
    echo '<script>window.location.href = "./index.php?etapa=4'.$voltar.'";</script>';
?>