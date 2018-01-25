<?php
$link = mysqli_connect("localhost", "root", "", "test");

if (!$link) {
    echo "Error: Unable to connect to MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}

echo  "Success: A proper connection to MySQL was made! <br>." . PHP_EOL;
echo "Host information: " . mysqli_get_host_info($link) . PHP_EOL . "<br>";


?>