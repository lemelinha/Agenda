<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Agenda</title>
    <link rel="stylesheet" href="static/style.css?v=<?= time() ?>">
    <?php
        date_default_timezone_set("America/Sao_Paulo");
    ?>
</head>
<body style="background-color: #212152;">
    <div class="pagina-nova-tarefa">
        <h1>Olá XXXX</h1>
        <button class="btn">Sair</button>
        <form method="get">
            <h1>Nova tarefa</h1>
            <input type="text" name="nome-nova-tarefa" id="nome-nova-tarefa" required placeholder="Nome da Nova Tarefa">
            <textarea name="desc-nova-tarefa" id="desc-nova-terefa" cols="30" rows="10" required placeholder="Descrição da tarefa"></textarea>
            <div class="data-limite" style="display: flex; flex-direction: column; row-gap: 5px;">
                <label for="verificar-data-limite">Terá data limite?</label>
                <input type="checkbox" name="verificar-data-limite" id="verificar-data-limite">
                <input type="date" name="data-limite" id="data-limite" style="display: none;" min="<?= date("Y-m-d", strtotime("+1 day")) ?>" required>
            </div>
            <input type="submit" value="Salvar Tarefa" name="form">
        </form>
    </div>
    <div class="pagina-minhas-tarefas">
        <h1>Suas Tarefas</h1>
        <div class="tarefa">
            <h2>[nome da tarefa]</h2>
            <p class="desc-tarefa">
                descricao
            </p>
            <span>[data de entrega -> verde se esta no prazo / vermelho se esta fora do prazo]</span>
            <div class="botoes">
                <button class="btn" id="btn-concluida">Concluída</button>
                <button class="btn" id="btn-excluir">Excluir</button>
            </div>
            <hr style="width: 100%; height: 2px; background-color: #000; border: 0;">
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="static/script.js?v=<?= time() ?>"></script>
</body>
</html>