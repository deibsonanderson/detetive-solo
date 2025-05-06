<?php
session_start();
$CARTAS_BASE = array(
    //ARMA
    "VENENO" => array("codigo" => 50, "nome" => "Veneno", "tipo" => "ARMA", "imagem" => "50.png"),
    "FACA" => array("codigo" => 51, "nome" => "Faca", "tipo" => "ARMA", "imagem" => "51.png"),
    "ESPINGARDA" => array("codigo" => 52, "nome" => "Espingarda", "tipo" => "ARMA", "imagem" => "52.png"),
    "ARMA_QUIMICA" => array("codigo" => 53,"nome" =>  "Arma Quimica", "tipo" => "ARMA", "imagem" => "53.png"),
    "PA" => array("codigo" => 54, "nome" =>  "Pá", "tipo" => "ARMA", "imagem" => "54.png"),
    "PE_DE_CABRA" => array("codigo" => 55, "nome" =>  "Pé de Cabra", "tipo" => "ARMA", "imagem" => "55.png"),
    "SOCO_INGLES" => array("codigo" => 56, "nome" => "Soco Inglês", "tipo" => "ARMA", "imagem" => "56.png"),
    "TESOURA" => array("codigo" => 57, "nome" => "Tesoura", "tipo" => "ARMA", "imagem" => "57.png"),
    
    //SUSPEITO
    "ADVOGADO" => array("codigo" => 70, "nome" => "Advogado - Sr. Marinho", "tipo" => "SUSPEITO", "pino" => "VERDE", "local" => "PRACA_CENTRAL", "imagem" => "70.png"),
    "SARGENTO" => array("codigo" => 71, "nome" => "Sargento - Bigode", "tipo" => "SUSPEITO", "pino" => "AMARELO", "local" => "PREFEITURA", "imagem" => "71.png"),
    "MORDOMO" => array("codigo" => 72, "nome" => "Mordomo - James", "tipo" => "SUSPEITO", "pino" => "AZUL", "local" => "MANSAO", "imagem" => "72.png"),
    "MEDICA" => array("codigo" => 73, "nome" => "Medica - Dona Violeta", "tipo" => "SUSPEITO", "pino" => "ROSA", "local" => "HOSPITAL", "imagem" => "73.png"),
    "DANCARINA" => array("codigo" => 74, "nome" => "Dancarina - Srta. Rosa", "tipo" => "SUSPEITO", "pino" => "VERMELHO", "local" => "BOATE", "imagem" => "74.png"),
    "FLORISTA" => array("codigo" => 75, "nome" => "Florista - Dona Branca", "tipo" => "SUSPEITO", "pino" => "BRANCO", "local" => "FLORICULTURA", "imagem" => "75.png"),
    "CHEF_COZINHA" => array("codigo" => 76, "nome" => "Chef de Cozinha - Tony Gourmet", "tipo" => "SUSPEITO", "pino" => "MARROM", "local" => "RESTAURANTE", "imagem" => "76.png"),
    "COVEIRO" => array("codigo" => 77, "nome" => "Coveiro - Sergio Saturno", "tipo" => "SUSPEITO", "pino" => "PRETO", "local" => "CEMITERIO", "imagem" => "77.png"),
    
    //LOCAL
    "PREFEITURA" => array("codigo" => 89, "nome" => "Prefeitura", "tipo" => "LOCAL", "imagem" => "89.png"),
    "MANSAO" => array("codigo" => 90, "nome" => "Mansão", "tipo" => "LOCAL", "imagem" => "90.png"),
    "BANCO" => array("codigo" => 91, "nome" => "Banco", "tipo" => "LOCAL", "imagem" => "91.png"),
    "BOATE" => array("codigo" => 92, "nome" => "Boate", "tipo" => "LOCAL", "imagem" => "92.png"),
    "ESTACAO_TREM" => array("codigo" => 93, "nome" => "Estação de Trem", "tipo" => "LOCAL", "imagem" => "93.png"),
    "RESTAURANTE" => array("codigo" => 94, "nome" => "Restaurante", "tipo" => "LOCAL", "imagem" => "94.png"),
    "PRACA_CENTRAL" => array("codigo" => 95, "nome" => "Praça Central", "tipo" => "LOCAL", "imagem" => "95.png"),
    "HOTEL" => array("codigo" => 96, "nome" => "Hotel", "tipo" => "LOCAL", "imagem" => "96.png"),
    "HOSPITAL" => array("codigo" => 97, "nome" => "Hospital", "tipo" => "LOCAL", "imagem" => "97.png"),
    "FLORICULTURA" => array("codigo" => 98, "nome" => "Floricultura", "tipo" => "LOCAL", "imagem" => "98.png"),
    "CEMITERIO" => array("codigo" => 99, "nome" => "Cemitério", "tipo" => "LOCAL", "imagem" => "99.png")
);
?>