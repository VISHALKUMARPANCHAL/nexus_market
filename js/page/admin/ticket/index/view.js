function openTextbox() {
    const td = event.target.closest("td");
    const input = document.createElement("input");
    input.type = "text";
    input.placeholder = "Enter comment";
    td.appendChild(document.createElement("br"));
    td.appendChild(input);
}
function complete(btn) {
    let tds=$(btn).parent().parent().find('td');
    tds.each(function (index,td){
        if($(td).attr('rowspan')==1){
            // console.log($(td).data('complete-id'));
            ajaxCallForComplete($(td).data('complete-id'));
        }
    })
}
function completesave(btn,mainParentbtn) {
    let tds=$(btn).closest('tr').find('td');
    let maintd=$(mainParentbtn).closest('tr').find('td')[0];
    
    // let tds=$(btn).closest('tr').find('td');
    tds.each(function (index,td) { 
        // console.log(maintd);
        let row_span=parseInt($(maintd).attr('rowspan'))||1;
        // console.log(row_span);
        
        if(row_span>1){
            $(maintd).attr('rowspan',row_span-1);
        }
        });
    tds.each(function (index,td){
        if($(td).attr('rowspan')==1){
            console.log($(td).data('complete-id'));
            ajaxCallForComplete($(td).data('complete-id'));
        }
    });
}

$('#saveall').on('click', function() {
    let btns=$('button');
    let mainbtn=[];
    btns.each(function(i,btn){
        let input=$(btn).parent().next().find('input');
        if($(btn).text()=="Complete" && (input.length==0 || input.val()=='')){
            mainbtn.push(btn);
        }
    });
    console.log(mainbtn);
    btns.each(function(i,btn){
        let input=$(btn).parent().next().find('input');
        if($(btn).text()=="Complete" && (input.length==0 || input.val()=='')){
            completesave(btn,mainbtn[0]);
        }
    });
    
    $('input[type="text"]').each(function(index, element) {
        let val = $(element).val();
        if(val!=''){
            let parentId = $(element).parent().data('node-id');
            ajaxCall(val, parentId);
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
