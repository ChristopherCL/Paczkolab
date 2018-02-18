<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $sizes = Size::loadAll($conn, isset($pathId) ? $pathId : null);
    $jsonSizes = [];
    
    foreach ($sizes as $size) {
        $jsonSizes[] = json_decode(json_encode($size), true);
    }
    
    $response = ['success' => $jsonSizes];
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $size = new Size;
    
    $size->setSize($_POST['size']);
    $size->setPrice($_POST['price']);
    
    $size->save();

    $response = ['success' => [json_decode(json_encode($size), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] === 'PATCH') {
    parse_str(file_get_contents("php://input"), $patchVars);
    
    $sizeToEdit = Size::loadAll($conn, $pathId)[0];
    $sizeToEdit->setSize($patchVars['size']);
    $sizeToEdit->setPrice($patchVars['price']);

    $sizeToEdit->save();

    $response = ['success' => [json_decode(json_encode($sizeToEdit), true)]];
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $deleteVars);

    $sizeToDelete = Size::loadAll($conn, $pathId)[0];
    $sizeToDelete->delete();

    $response = ['success' => 'deleted'];
} else {
    $response = ['error' => 'Wrong request method'];
}
