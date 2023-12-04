<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Agenda</title>
    <link rel="stylesheet" href="static/style.css?v=<?= time() ?>">
</head>
<body style="background-color: #212152;">
    <div class="pagina-nova-tarefa">
        <h1>Olá XXXX</h1>
        <form method="get">
            <h1>Nova tarefa</h1>
            <input type="text" name="nome-nova-tarefa" id="nome-nova-tarefa" required placeholder="Nome da Nova Tarefa">
            <textarea name="desc-nova-tarefa" id="desc-nova-terefa" cols="30" rows="10" placeholder="Descrição da tarefa"></textarea>
            <div class="data-limite" style="display: flex; flex-direction: column; row-gap: 5px;">
                <label for="verificar-data-limite">Terá data limite?</label>
                <input type="checkbox" id="verificar-data-limite">
                <input type="date" name="data-limite" id="data-limite" style="display: none;" min="<?= date("Y-m-d") ?>">
            </div>
            <input type="submit" value="Salvar Tarefa" name="form">
        </form>
    </div>
    <div class="pagina-minhas-tarefas">

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="static/script.js"></script>
</body>
</html>