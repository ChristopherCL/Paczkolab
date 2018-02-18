$(document).ready(function() {

    var url = '../../router.php/size/';

    // Send new SIZE to database
    $('#add-size input[type=submit]').on('click', function(event) {
        event.preventDefault();
        var price = $('#add-size #price').val(),
            size = $('#add-size #size').val();
            
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                size: size,
                price: price
            },
             dataType: 'json'
        }).done(function(response){
            alert('Dodano nowy rozmiar paczki');
            $('#price, #size').val('');
        }).fail(function(response){
            alert( "Wystąpił błąd");
        });
    });
});