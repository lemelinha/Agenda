<?php
    require_once "connection.php";

    header("Content-Type: application/json");

    $sql = "
            update tb_tarefas set 
            st_tarefa = :alteracao,
            dt_termino = current_date
            where cd_tarefa= :cdtarefa;
    ";

    if ($_GET["alteracao"] == "concluir") {
        $alteracao = "C";
    } else {
        $alteracao = "E";
    }

    $tarefa_alterada = $GLOBALS["conn"]->prepare($sql);
    $tarefa_alterada->bindParam(":alteracao", $alteracao);
    $tarefa_alterada->bindParam(":cdtarefa", $_GET["cd_tarefa"]);
    $tarefa_alterada->execute();

    echo json_encode([]);