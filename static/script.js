$("form a").click(function () {
    $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");
});

$("#form-cadastro").submit(function () {
    var senha = document.getElementById("senha-cadastro").value;
    var senha_confirmar = document.getElementById("senha-cadastro-confirmar").value;
    if (senha == senha_confirmar) {
        $(this).submit();
    } else{
        $("#confirmar-senha").html("As senhas devem ser iguais");
        return false;
    }
});

$(".botoes .btn").click(function () {
    var id_array = $(this).get(0).id.split("-");
    
    $.ajax({
        type: "GET",
        url: "static/ajax.php",
        data: {
            funcao: "AlterarST",
            cd_tarefa: id_array[2],
            alteracao: id_array[1]
        },
        dataType: "json",
        success: function(){
            AnimacaoTarefas(id_array);
        }
    })
});

function AnimacaoTarefas(id_array){
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
                    }, 300, function () {
                        tarefa.hide()
                    }); // animação da tarefa para o lado do botao selecionado
    
    var transicao_tarefa = tarefa.height() + parseInt(tarefa.css("margin-bottom").split("px")) + (parseInt(tarefa.css("padding").split("px"))*2);
    $(`#${tarefa.get(0).id} ~ *`).animate({
                                                y: `-=${transicao_tarefa}px`
                                            }, 300, function () {
                                                $(this).css({ y: 0 })
                                            }
                                        ); // animacao das tarefas abaixo para cima, criando uma animação mais suave
}