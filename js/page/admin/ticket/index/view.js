function openTextbox() {
    const td = event.target.closest("td");
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Enter comment";
    td.appendChild(document.createElement("br"));
    td.appendChild(input);
}
function complete(btn) {
    $(btn).prev().hide();
    $(btn).hide();
}

$('#saveall').on('click', function() {
    $('input[type="text"]').each(function(index, element) {
        let val = $(element).val();
        let parentId = $(element).parent().data('node-id');
        ajaxCall(val, parentId);
    });

})

function ajaxCall(cmt, pid) {
    let tid = $('#ticketId').html().trim();
    $.ajax({
        url: "http://localhost/ecommerceweb/admin/ticket_index/savecomment",
        type: 'post',
        data: {
            comment: cmt,
            parent_id: pid,
            ticket_id: tid
        },
        success: function(res) {
            console.log(res);
            window.location.reload();
        },
        error: function(err) {
            console.log(err);
        },
    });
}