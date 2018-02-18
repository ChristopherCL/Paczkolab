$(document).ready(function() {

    var url = '../../router.php/parcel/',
        viewParcel = $('#view-parcel');

    //// Show PARCEL data in the view/parcel
    function loadParcelView() {

        $.ajax({
            type: 'GET',
            url: url,
            contentType: 'application/json',
            dataType: 'json'
        }).done(function(response) {
            insertContentParcel(response);
        }).fail(function(response) {
            alert( "Wystąpił błąd");
        });
    }
    loadParcelView();

    // PARCEL
    // Create table element to put data from db 
    // Do action (edit, delete) on data in table
    function insertContentParcel(parcel) {
        $.each(parcel, function(){
            var tr = $('<tr>'),
                tdId = $('<td>', {class: "id"}),
                tdAddress = $('<td>', {class: "address"}),
                tdName = $('<td>', {class: "name"}),
                tdSize = $('<td>', {class: "size"}),
                tdPrice = $('<td>', {class: "price"}),
                tdAction = $('<td>', {class: "action"}),
                actionDelete = $('<button>', {class: "delete-btn"}).text('Usuń'),
                actionForm = $('<form>', {class: "edit-form hide"}),
                inputAddress = $('<input>', {name: "address", id: "address"}),
                inputName = $('<input>', {name: "name", id: "name"}),
                inputSize = $('<input>', {name: "size", id: "size"}),
                inputPrice = $('<input>', {name: "price", id: "price"}),
                inputSubmit = $('<input>', {type: "submit"});

            // Create table element
            tr.append(tdId, tdAddress, tdName, tdSize, tdPrice, tdAction);
            tdAction.append(actionDelete, actionForm);
            actionForm.append(inputAddress, inputName, inputSize, inputPrice, inputSubmit);
            viewParcel.append(tr);

            // Insert proper address
            function insertAddress(address) {
                $.each(address, function() {
                    tdAddress.text(this.city + ' ' + this.code + ', ' +  this.street + ' ' + this.flat);
                });    
            }

            var addressId = this.address_id;
            var url = '../../router.php/address/';

            // Show data from database ADDRESS in table
            $.ajax({
                type: 'GET',
                url: url + addressId,
                contentType: 'application/json',
                dataType: 'json'
            }).done(function (response) {
                insertAddress(response);
            }).fail(function (response) {
                alert( "Wystąpił błąd");
            });

            // Insert proper name
            function insertName(user) {
                $.each(user, function() {
                    tdName.text(this.name + ' ' + this.surname);
                });
            }

            var userId = this.user_id;
            var url = '../../router.php/user/';

            // Show data from database USER in table
            $.ajax({
                type: 'GET',
                url: url + userId,
                contentType: 'application/json',
                dataType: 'json'
            }).done(function (response) {
                insertName(response);
            }).fail(function (response) {
                alert( "Wystąpił błąd");
            });

            // Insert proper size and price
            function insertSize(size) {
                $.each(size, function() {
                    tdSize.text(this.size);
                    tdPrice.text(this.price);
                })
            }

            var sizeId = this.size_id;
            var url = '../../router.php/size/';

            // Show data from database SIZE in table
            $.ajax({
                type: 'GET',
                url: url + sizeId,
                contentType: 'application/json',
                dataType: 'json'
            }).done(function (response) {
                insertSize(response);
            }).fail(function (response) {
                alert( "Wystąpił błąd");
            });
            tdId.text(this.id);
        });

        // Delete PARCEL data
        viewParcel.on('click', '.delete-btn', function(e){
            e.preventDefault();
        
            var id = $(this).parent().parent().find('td[class=id]').text();
            
            $.ajax({
                type: "DELETE",
                url: url,
                data: {
                    id: id
                },
                dataType: 'json'
            }).done(function (response) {
                location.reload();
                alert('Użytkownik został usunięty');
            }).fail(function (response) {

            });
        });
    }
});