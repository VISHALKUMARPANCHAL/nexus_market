
// function filluid(id) {
//     $('#uid').html(id);
// }
$(function() {
    $(document).on('click', '.approve', function(event) {
        // let uid = $('#uid').html().trim();
        let uid = $(this).data('userid');
        let upstatus = "Approved";
        
        ajaxcall(uid, upstatus);
    });
    $(document).on('click', '.reject', function(event) {
        let uid = $(this).data('userid');
        let upstatus = "Rejected";
        ajaxcall(uid, upstatus);
    });

    function ajaxcall(uid, upstatus) {
        $.ajax({
            url: "http://localhost/ecommerceweb/admin/ems_events/changestatus",
            type: 'post',
            data: {
                status: upstatus,
                userid: uid,
                id: $('#eid').html().trim()
            },
            success: function(res) {
                let extractedContent = $(res).find("#tablebody").html();
                $("#tablebody").empty().html(extractedContent);
                let extractedContent2 = $(res).find("#summarybody").html();
                $("#summarybody").empty().html(extractedContent2);
            },
            error: function(err) {
                console.log(err);
            },
        });
    }
});