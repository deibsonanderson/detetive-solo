<?php
    $_SESSION["numero_participante"] = $_GET["numero"];
    $suspeitos = listarCartaPeloTipo($CARTAS_BASE, 'SUSPEITO');
?>