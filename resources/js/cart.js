(function ($) {
    $('.item-quantity').on('change' ,function (e){
        $.ajax({
            url:"/cart/" + $(this).data('id'),
            method : 'put',
            data:{
                quantity : $(this).val(),
                _token : csrf_token
            }
        });
    });

})(jQuery);

(function ($) {
    $('.remove-item').on('click' ,function (e){
        let id = $(this).data('id')
        $.ajax({
            url:"/cart/" + id ,
            method : 'DELETE',
            data:{
                _token : csrf_token
            },
            success:respose =>{
                $(`#${id}`).remove();
            }
        });
    });

})(jQuery);
// (function ($) {
//     $('.create').on('submit' ,function (e){
//         $.ajax({
//             url:"/cart/",
//             method : 'post',
//             data:{
//                 product_id : $(this).data(id),
//                 quantity    :$(this).data(quantity).val(),
//                  _token : csrf_token
//             },
//             success:respose =>{
//                 $(`#${id}`).remove();
//             }
//         });
//     });
//
// })(jQuery);
