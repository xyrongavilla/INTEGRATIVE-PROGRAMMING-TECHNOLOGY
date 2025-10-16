<?php
//Set the header: header('Content-Type: application/json');
header('Content-Type: application/json');

//Create an array containing user profile information (id, name, email, status).
$user = array(
    "id" => 23149391,
    "name" => "Xyrll",
    "email" => "xyrllrongavilla14@gmail.com",
    "status" => "active"
);
//Use json_encode() to output the response.
echo json_encode($user);
?>
