<?php
require_once('./conf.php');

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};

//a táblákat és oszlopait előre létrehoztam a HeidiSQL-ben

$fileOpen = fopen('./morzeabc.txt', 'r') or exit("A fájl nem található");

while (!feof($fileOpen)) {
    $line = fgets($fileOpen);
    $line2 = substr($line, 0, strlen($line) - 2);
    $arrayOfLines[] = explode("\t", $line2);
    $arrayMorze = $arrayOfLines;
    $arrayMorzeAbc = array_shift($arrayMorze);
}

fclose($fileOpen);

foreach ($arrayMorze as $di) {
    $sql = "INSERT INTO morze (Betű, Morzejel) VALUES ('{$di[0]}','{$di[1]}')";
    if (!mysqli_query($conn, $sql)) {
        die('Error: ' . mysqli_error($conn));
    }
}

