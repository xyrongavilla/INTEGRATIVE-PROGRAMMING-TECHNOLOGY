<?php
//Declare a PHP associative array with keys: name, age, and course.
$student = array(
   "name" => "Jocelyn Lobos",
   "age" => 21,
   "course" => "BSIT"
);
//Use json_encode() to convert the array to a JSON string.
$json = json_encode($student);

//Output the JSON string in the browser. Using notepad++ and xampp
echo $json;

?>