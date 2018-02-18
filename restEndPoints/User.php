<?php

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $users = isset($pathId) ? [User::load($pathId)] : User::loadAll();
    
    $jsonUsers = [];
    foreach ($users as $user) {
        $jsonUsers[] = json_decode(json_encode($user), true);
    }
    
    $response = $jsonUsers;
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = new User();
    $user->setName($_POST['name']);
    $user->setSurname($_POST['surname']);
    $user->setCredits($_POST['credits']);
    //$user->setAddress_id($_POST['address_id']);

    $user->save();

    $response = [json_decode(json_encode($user), true)];
} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    $userToEdit = User::load($pathId);
    $userToEdit->setName($patchVars['name']);
    $userToEdit->setSurname($patchVars['surname']);
    $userToEdit->setCredits($patchVars['credits']);
    //$userToEdit->setAddress_id($patchVars['address_id']);

    $userToEdit->update();

    $response = [json_decode(json_encode($userToEdit), true)];
} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);
    $userToDelete = User::load($pathId);
    $userToDelete->delete();

    $response = 'deleted';
} else {
    $response = ['error' => 'Wrong request method'];
}
