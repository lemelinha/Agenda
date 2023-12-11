<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Agenda</title>
    <link rel="stylesheet" href="static/style.css?v=<?= time() ?>">
    <?php
        ob_start();
        date_default_timezone_set("America/Sao_Paulo");

        require_once "static/connection.php";
        require_once "static/functions.php";

        if(!ValidarToken()) {
            $_SESSION["msg-login"] = "<p style='color:#f00;'>Efetue o Login para entrar nessa página</p>";

            setcookie("token");

            header("Location: index.php");
            exit();
        }
        $token = RecuperarDadosToken();
    ?>
</head>
<body style="background-color: #212152;">
    <div class="pagina-nova-tarefa">
        <h1>Olá <?= $token->nm_usuario ?></h1>
        <button class="btn" onclick="javascript:window.location.href = 'logout.php'">Sair</button>
        <form method="get">
            <h1>Nova tarefa</h1>
            <input type="text" name="nome-nova-tarefa" id="nome-nova-tarefa" required placeholder="Nome da Nova Tarefa">
            <textarea name="desc-nova-tarefa" id="desc-nova-terefa" cols="30" rows="10" required placeholder="Descrição da tarefa"></textarea>
            <label for="data-prazo">Prazo da tarefa:</label>
            <input type="date" name="data-prazo" id="data-prazo" min="<?= date("Y-m-d") ?>" required>
            <input type="submit" value="Salvar Tarefa" name="form">
            <?php
                if(isset($_SESSION["msg-nova-tarefa"])){
                    echo $_SESSION["msg-nova-tarefa"];
                    unset($_SESSION["msg-nova-tarefa"]);
                }
            ?>
        </form>
    </div>

    <?php
        if(!empty($_GET)){
            if($_GET['form'] == 'Salvar Tarefa'){
                var_dump($token);
                NovaTarefa($token->cd_usuario, $_GET['nome-nova-tarefa'], $_GET['desc-nova-tarefa'], $_GET['data-prazo']);
            }
        }
    ?>

    <div class="pagina-minhas-tarefas">
        <h1>Suas Tarefas</h1>
        
        <?php
            ListarTarefas($token->cd_usuario, "P");
        ?>

        <!-- MODELO
            <div class="tarefa">
                <h2>[nome da tarefa]</h2>
                <p class="desc-tarefa">
                    descricao
                </p>
                <span>[data de registro]</span>
                <span>[data de entrega -> verde se esta no prazo / vermelho se esta fora do prazo]</span>
                <div class="botoes">
                    <button class="btn" id="btn-concluir">Concluída</button>
                    <button class="btn" id="btn-excluir">Excluir</button>
                </div>
            </div>
        -->
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.transit/0.9.12/jquery.transit.js" integrity="sha512-VRuRE7kBxU+JQr4R/7Y75cMMdeNnn5zDZRpT4qtEzAJXdMkmFPPGbS56Ch9/Lr2g5vnwN7PxtIdBvevTMVpnug==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="static/script.js?v=<?= time() ?>"></script>
</body>
</html>