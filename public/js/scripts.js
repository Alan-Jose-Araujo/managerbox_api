$(document).ready(function(){
    // Ativar tooltips
    $("body").tooltip({
        selector: '[data-toggle="tooltip"]'
    });

    // Adicionar confirmação ao excluir item
    $("form").on("submit", function(e) {
        return confirm("Tem certeza que deseja excluir este item?");
    });
});
