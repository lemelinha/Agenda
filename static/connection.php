<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $dbname = "db_agenda";

    try {
        // conectando ao banco
        $conn = new PDO("mysql:host=$host;dbname=" . $dbname, $user, $pass);
        
        //echo "Conexao realizada!";
    }catch (PDOException $err) {
        echo "ERRO: conexao nao realizada -> " . $err->getMessage();
    }
?>