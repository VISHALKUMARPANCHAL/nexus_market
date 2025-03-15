$(document).ready(function() {
    $("#increase").click(function() {
        let quantity = parseInt($("#quantity").val());
        $("#quantity").val(quantity + 1);
    });

    $("#decrease").click(function() {
        let quantity = parseInt($("#quantity").val());
        if (quantity > 1) {
            $("#quantity").val(quantity - 1);
        }
    });
});