<?php
require_once('./conf.php');
require_once('./metodus.php');
$conn = mysqli_connect($server, $user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};


$translation = fopen("translation.txt", "w") or die("Fájl megnyitása nem lehetséges!");
fclose($translation);

$translation = fopen("translation.txt", "a") or die("Fájl megnyitása nem lehetséges!");

$sql = "SELECT szerzo, idezet FROM morzekod";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $textLine = Morze2Szöveg($row['szerzo']);
    $textLine2 = Morze2Szöveg($row['idezet']);
    fwrite($translation, $textLine . ": " . $textLine2 . "\n");
}
fclose($translation);
