<?php
require_once('./conf.php');
require_once('./metodus.php');
$conn = mysqli_connect($server, $user, $password, $db);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
};
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <h4>3. Határozza meg és írja ki a képernyőre a minta szerint, hogy hány karakter található a
        morzeabc.txt állományban!</h4>
    <?php
    $sql = "SELECT COUNT('Betű') as szam FROM morze";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            print($row['szam']);
        }
    } else {
        print("0 eredmény");
    }
    ?>
    <h4>4. Kérjen be a felhasználótól egy karaktert a billentyűzetről és írja ki a képernyőre a minta<br>
        szerint, hogy mi a morzekódja! Ha a karakter nem található meg a kódtárban, akkor írja ki<br>
        a „Nem található a kódtárban ilyen karakter!” szöveget!</h4>
    <form action="index.php" method="POST">
        Karakter: <input type="text" name="karakter" maxlength="1"><br>
        <input type="submit" name="submit">


    </form>
    <h5>
        <?php
        if (isset($_POST['karakter'])) {
            $karakter = $_POST['karakter'];

            $sql2 = "SELECT Morzejel FROM morze WHERE Betű = '$karakter'";
            $result2 = mysqli_query($conn, $sql2);
            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    print('A karakter morzejkódja: ' . $row2['Morzejel']);
                }
            } else {
                print("Nem található a kódtárban ilyen karakter!");
            }
        }
        ?>
    </h5>
    <h4>5. A második UTF-8 kódolású morze.txt állomány morzekódban tartalmaz idézeteket különböző szerzőktől.<br>
        Az állomány sorai két részre tagolódnak. A két részt pontosvessző választja el egymástól.<br>
        Az első rész a szerzőt, a második rész az idézetet tartalmazza. A fájlban maximum 200 sor lehet.<br>
        A morzekódban a betűket három, míg a szavakat hét szóköz választja el egymástól.<br>
        Olvassa be a morze.txt állományban található adatokat és tárolja el egy megfelelően megválasztott adatszerkezetben!</h4>
    <form action="index.php" method="POST">
        Morzekód: <input type="file" name="morze"><br>
        <input type="submit" name="submit2">
    </form>
    <?php
    if (isset($_POST['morze'])) {
        $text = $_POST['morze'];
        $lines = count(file($text));
        if ($lines < 200) {
            $handler = fopen($text, 'r') or exit("A fájl nem található");

            while (!feof($handler)) {
                $arrayOfLines[] = explode('   ;', fgets($handler));
            }

            fclose($handler);
        }

        foreach ($arrayOfLines as $di) {
            $sql = "INSERT INTO morzekod (szerzo, idezet) VALUES ('{$di[0]}','{$di[1]}')";
            if (!mysqli_query($conn, $sql)) {
                die('Error: ' . mysqli_error($conn));
            }
        }
    }
    ?>
    <h4>7. A print(Morze2Szöveg() metódus segítségével határozza meg és írja ki a képernyőre a minta
        szerint az első idézet szerzőjének nevét!
    </h4>

    <?php
    $sql7 = "SELECT szerzo FROM morzekod WHERE id='1'";
    $result7 = mysqli_query($conn, $sql7);
    $row7 = mysqli_fetch_array($result7);
    $firstQuote = ($row7['szerzo']);
    print(Morze2Szöveg($firstQuote));
    ?>

    <h4>8. Írja ki a képernyőre, hogy melyik idézet szövege a leghosszabb! Az idézetnek jelenjen
        meg a szerzője is a minta szerint!</h4>

    <?php
    $sql8 = "SELECT szerzo, idezet, MAX(LENGTH(idezet)) FROM morzekod";
    $result8 = mysqli_query($conn, $sql8);
    $row8 = mysqli_fetch_array($result8);
    $maxAuthor = ($row8['szerzo']);
    $maxQuote = ($row8['idezet']);
    print(Morze2Szöveg($maxAuthor));
    print(": ");
    print(Morze2Szöveg($maxQuote));
    ?>

    <h4>9. Arisztotelésztől több idézet is van a dokumentumban, határozza meg és írja ki a
        képernyőre a minta szerint mindegyik idézetet!</h4>
    <?php
    $sql9 = "SELECT szerzo, idezet FROM morzekod WHERE szerzo ='.-   .-.   ..   ...   --..   -   ---   -   .   .-..   ..-..   ...   --..'";
    $result91 = mysqli_query($conn, $sql9);
    $row91 = mysqli_fetch_array($result91);
    $aristoteles = ($row91['szerzo']);
    print(Morze2Szöveg($aristoteles));

    $result92 = mysqli_query($conn, $sql9);
    print(':<br>');
    while ($row9 = mysqli_fetch_array($result92)) {
        print(Morze2Szöveg($row9['idezet']));
        print('<br>');
    }


    ?>





</body>

</html>