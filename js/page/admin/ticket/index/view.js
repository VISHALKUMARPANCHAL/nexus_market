function openTextbox(btn) {
    const td = $(btn).parent();
    const input =$("<input type='text' placeholder='Enter comment'>");
    $(td).append($("<br/>"));
    $(td).append(input);
}
function complete(btn) {
    let comment_id=$(btn).parent().data('complete-id');
    ajaxCallForComplete(comment_id);
}

$('#saveall').on('click', function() {
    let btns=$('button');
    btns.each(function(i,btn){
        let input=$(btn).parent().next().find('input');
        if($(btn).text()=="Complete" && (input.length==0 || input.val()=='')){
            complete(btn);
        }
    });
    $('input[type="text"]').each(function(index, element) {
        let val = $(element).val();
        let level = parseInt($('#maxlevel').text())+1;
        if(val!=''){
            let parentId = $(element).parent().data('node-id');
            ajaxCall(val, parentId,level);
        }
    });
})

function ajaxCallForComplete(cid) {
    $.ajax({
        url: "http://localhost/ecommerceweb/admin/ticket_index/update",
        type: 'post',
        data: {
            comment_id: cid
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
function ajaxCall(cmt, pid,lvl) {
    let tid = $('#ticketId').html().trim();
    $.ajax({
        url: "http://localhost/ecommerceweb/admin/ticket_index/savecomment",
        type: 'post',
        data: {
            comment: cmt,
            parent_id: pid,
            ticket_id: tid,
            level: lvl
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
