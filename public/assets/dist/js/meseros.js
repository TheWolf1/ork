

function mostrarUser(id,name,rol,email) {
    

    $("#idUserUpdate").val(id);

    $("#nameUp").val(name);
    $("#updateMesero").modal("show");


    $("#rolUp option").attr("selected", false);
    $("#rolUp option[value=" + rol + "]").attr("selected", true);


    $("#emailUp").val(email);
}