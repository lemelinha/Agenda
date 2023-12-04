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

$("#verificar-data-limite").click(function () {
    $("#data-limite").toggle();
});
