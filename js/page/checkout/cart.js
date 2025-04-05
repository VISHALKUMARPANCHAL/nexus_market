$(function() {
    $(document).on('click','#type',function (event) {  
        // console.log(1);
        $.ajax({
            url:"http://localhost/ecommerceweb/checkout/cart/applycoupon",
            type:'post',   
            data:{
                coupon_code:$("#coupon_code").val(),
                sub_total:$("#sub_total").val(),
                type:$("#type").val()
            },
            success:function (res) { 
                let extractedContent = $(res).find("#couponCodediv").html();
                $("#couponCodediv").empty().html(extractedContent);
                let extractedContent2 = $(res).find("#orderSummarydiv").html();
                $("#orderSummarydiv").empty().html(extractedContent2);
            },
            error:function (err) { 
                console.log(err);
             },
        });
    });
});