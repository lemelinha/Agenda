$("form a").click(function () {
    $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");
});

$("#form-cadastro").submit(function () {
    var senha = document.getElementById("senha-cadastro").value;
    var senha_confirmar = document.getElementById("senha-cadastro-confirmar").value;
    if (senha == senha_confirmar) {
        document.getElementById("form-cadastro").submit();
    } else{
        $("#confirmar-senha").html("As senhas devem ser iguais");
        return false;
    }
});

$(".botoes .btn").click(function () {
    var id_array = $(this).get(0).id.split("-");
    var tarefa = $(`#tarefa-${id_array[2]}`);
    var operador;
    if (id_array[1] == "concluir"){
        operador = '-';
    } else {
        operador = '+';
    }
    tarefa.transition({ 
                        x: `calc(${operador}${tarefa.width()}px ${operador} (${tarefa.css("padding")}*4))`,
                        opacity: 0 
                    });
});