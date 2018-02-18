$(document).ready(function() {

    var url = '../../router.php/address/';

    // Send new ADDRESS to database
    $('#add-address input[type=submit]').on('click', function(event) {
        event.preventDefault();
        var address = $('#add-address');
        var city = address.find('#city').val(),
            code = address.find('#code').val(),
            street = address.find('#street').val(),
            flat = address.find(' #flat').val();
            
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                city: city,
                code: code,
                street: street,
                flat: flat
            },
            dataType: 'json'
        }).done(function(respone){
            alert('Dodano nowy adres');
            $('#city, #code, #street, #flat').val('');
        }).fail(function (response){
            alert("Wystąpił błąd");
        });
    });
});