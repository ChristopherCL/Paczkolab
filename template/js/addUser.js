$(document).ready(function() {

    var urlUser = '../../router.php/User',
        urlAddress = '../../router.php/address/';

    // Functions which get data address from the other class
    var optionAddress = $('#address_option');

    function showAddressOption(address) {
        $.each(address, function(){
            var option = $('<option>');
                
            optionAddress.append(option);
            option.text(this.city + ' ' + this.code + ', ' + this.street + ' ' + this.flat);
            option.attr('data-id', this.id);
        })
    }

    /// Show available data address in select input to add a new User
    /// Send request to address class to get full list with addresses
    function loadDataToAddUser() {

        $.ajax({
            type: 'GET',
            url: urlAddress,
            contentType: 'application/json',
            dataType: 'json'
        }).done(function(response){
            showAddressOption(response);
        }).fail(function(response){
            alert( "Wystąpił błąd");
        });
    }
    //loadDataToAddUser();

    // Send new USER to database
    $('#add-user input[type=submit]').on('click', function(event) {
        event.preventDefault();
            var user = $('#add-user');
            var address = user.find('#address_option option:selected').attr('data-id'),
            name = user.find(' #name').val(),
            surname = user.find('#surname').val(),
            credits = user.find('#credits').val();
            
        $.ajax({
            type: 'POST',
            url: urlUser,
            data: {
                //address_id: address,
                name: name,
                surname: surname,
                credits: credits
            },
            dataType: 'json'
        }).done(function(response){
            alert('Dodano użytownika');
            $('#address_option, #name, #surname, #credits').val('');
        }).fail(function(response){
            alert( "Wystąpił błąd");
        });
    });
});