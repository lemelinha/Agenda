<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minhas Agenda</title>
    <link rel="stylesheet" href="static/style.css?v=<?= time() ?>">
    <?php
        ob_start();

        require_once "static/connection.php";
        require_once "static/functions.php";

        echo "<style>#form-cadastro{ display: none; }</style>";

        if(!empty($_GET)){
            if($_GET['form'] == "Logar"){
                LoginUsuario($_GET["usuario-login"], $_GET["senha-login"]);
            }
            if($_GET['form'] == "Cadastrar") {
                CadastrarUsuario($_GET["usuario-cadastro"], $_GET["senha-cadastro"]);
            }
        }
        if (ValidarToken()) {
            header("Location: dashboard.php");
        }
    ?>
</head>
<body style="background-image: radial-gradient(farthest-corner at 0 0, #FED64C, #FD7B42 20%, #CF388C, #4861CA);">
    <div class="pagina-login">
        <form method="get" id="form-login">
            <h1>Login</h1>
            <input type="text" name="usuario-login" id="usuario-login" required placeholder="Usuário" value="<?= $_GET["usuario-login"]??"" ?>" maxlength="30">
            <input type="password" name="senha-login" id="senha-login" required placeholder="Senha">
            <input type="submit" value="Logar" name="form">
            <?php 
                if(isset($_SESSION["msg-login"])){
                    echo $_SESSION["msg-login"];
                    unset($_SESSION["msg-login"]);
                }
            ?>
            <p>Não tem uma conta? <a href="#">Criar uma</a></p>
        </form>

        <form action="<?= $_SERVER["PHP_SELF"] ?>" method="get" id="form-cadastro">
            <h1>Cadastro</h1>
            <input type="text" name="usuario-cadastro" id="usuario-cadastro" required placeholder="Crie um Usuário">
            <input type="password" name="senha-cadastro" id="senha-cadastro" required placeholder="Crie uma Senha" minlength="8">
            <input type="password" id="senha-cadastro-confirmar" required placeholder="Confirmar Senha" minlength="8">
            <p id="confirmar-senha"></p>
            <input type="submit" value="Cadastrar" name="form">
            <?php 
                if(isset($_SESSION["msg-cadastro"])){
                    echo $_SESSION["msg-cadastro"];
                    unset($_SESSION["msg-cadastro"]);
                }
            ?>
            <p>Já tem uma conta? <a href="#">Entrar</a></p>
        </form>
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="static/script.js?v=<?= time() ?>"></script>
        <p style="margin-top: 10px">Desenvolvido por: <a href="https://instagram.com/lemelinha_" target="_blank" class="autoria">@lemelinha_</a></p>
    </div>
</body>
</html>