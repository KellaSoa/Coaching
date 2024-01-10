jQuery(function($) {

    //Send edit Status Inscription in backend
    $(".btn-send-edit").on( 'click', function(event) {
        event.preventDefault();
        $('.btn-send-edit').attr('disabled',true);

        let status = $(this).data("status");
        $("#status").val(status);

        if(status == 'waiting' && $('#link_payment').val() == ''){
            alert("Inserire il link del pagamento online prima di inviare la mail all'utente.");
            $('.btn-send-edit').removeAttr('disabled');
            return false;
        }

        let form= $("#form-edit-inscription");
        let ajaxurl = form.data("url");
        //console.log("submit edit status inscription");
        let form_data = form.serialize();
        //console.log(form_data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: form_data,
            success: function(response) {
                console.log('Success:', response);
                $('.btn-send-edit').removeAttr('disabled');
                let result = JSON.parse(response);
                window.location.href = result.redirect;
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
        return false;
    });

    //Delete item in list table
    $('.delete-item').on('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this item?')) {
            let itemId = $(this).data('item-id');
            let page = getUrlParameter('paged');
            let table = $(this).data('table');
            console.log(page);
            window.location.href = '?page='+table+'&action=delete&item=' + itemId+'&paged='+page;
        }
    });

    $("#send-reminder-payment").on("click", function (){
        $('#send-reminder-payment').attr('disabled',true);
        let ajaxurl = $(this).data("url");
        let idInscription = $(this).data("idinscription");
        let action = $(this).data("action");
        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {idInscription:idInscription, action: action},
            success: function(response) {
                console.log('Success:', response);
                $('#send-reminder-payment').removeAttr('disabled');
                let result = JSON.parse(response);
                window.location.href = result.redirect;
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
        return false;
    });
});

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};