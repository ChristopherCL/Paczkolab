<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $addresses = Address::loadAll($conn, isset($pathId) ? $pathId : null);
    $jsonAddresses = [];
    foreach ($addresses as $address) {
        $jsonAddresses[] = json_decode(json_encode($address), true);
    }
    $response = ['success' => $jsonAddresses];
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $address = new Address();
   
   $address->setCity($_POST['city']);
   $address->setPostalCode($_POST['code']);
   $address->setStreet($_POST['street']);
   $address->setApartment($_POST['flat']);
   
   $address->save();

   $response = ['success' => [json_decode(json_encode($address), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    
    $addressToEdit = Address::loadAll($conn, $pathId)[0];
    $addressToEdit->setCity($patchVars['city']);
    $addressToEdit->setPostalCode($patchVars['code']);
    $addressToEdit->setStreet($patchVars['street']);
    $addressToEdit->setApartment($patchVars['flat']);
   
    $addressToEdit->save();

    $response = ['success' => [json_decode(json_encode($addressToEdit), true)]];
    
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $addressToDelete = Address::loadAll($conn, $pathId)[0];
    $addressToDelete->delete();

    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}
