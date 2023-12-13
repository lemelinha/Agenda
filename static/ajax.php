<?php
    require_once "connection.php";
    require_once "functions.php";

    header("Content-Type: application/json");

    if($_GET["funcao"]=="AlterarST"){
        AlterarSTTarefa($_GET["alteracao"], $_GET["cd_tarefa"]);
    }

    echo json_encode([]);