<?php

//Declare a JSON string with name, age, and email.
$json = '{"name": "Jocelyn Lobos", "age": 21, "email": "JocelynLobos@gmail.com"}';

//Use json_decode() to convert it into a PHP object.
$data = json_decode($json);

//Use json_decode() to convert it into a associative array.
$dataArray = json_decode($json, true);

//Display individual values (e.g., name and email) in both formats.
echo "Object: " . $data->name . "<br>";
echo "Array: " . $dataArray['email'] . "<br>";

?> 
