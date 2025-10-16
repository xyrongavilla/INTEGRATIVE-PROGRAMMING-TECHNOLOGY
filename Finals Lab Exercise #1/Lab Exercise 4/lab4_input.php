<?php

$json_data = '{"username": "admin", "password": "1234"}';

$data = json_decode($json_data);

echo "Username: " . $data->username . "<br>";
echo "Password: " . $data->password;
?>
