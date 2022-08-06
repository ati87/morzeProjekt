<?php
require_once('./conf.php');

function db()
{
    $conn = mysqli_connect("localhost", "root", "", "blog");
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    };
    return $conn;
}
function Morze2Szöveg($morze1, $morze2 = 0)
{
    $conn = db();
    $output = "";
    if (isset($morze1) && array($morze1)) {
        $arrayOfMorzeWord = preg_split("/(\s\s\s+)/", $morze1);
        foreach ($arrayOfMorzeWord as $word) {
            $arrayOfMorze = preg_split("/(\s\s\s\s\s\s\s+)/", $word);

            foreach ($arrayOfMorze as $code) {

                $sql = "SELECT Betű FROM morze WHERE Morzejel= '$code'";
                $result = mysqli_query($conn, $sql);


                $row = mysqli_fetch_array($result);
                $output .= $row['Betű'];
            }
            $output .= ' ';
        }
    }
    return $output;
}


    /*     if (isset($morze1) && array($morze1)) {
        //itt  a szóelválasztó szerint szedjük szét
        // $arrayOfMorzeWord = preg_split("/(\s\s\s+|\s\s\s\s\s\s\s+|;)/", $morze1);
        $arrayOfMorzeWord = preg_split("/(\s\s\s+)/", $morze1);
        foreach ($arrayOfMorzeWord as $word) {
            //betűket elválasztó jel mentén vágjuk fel
            // $arrayOfMorze = preg_split('', $word);
            $arrayOfMorze = preg_split('/(\s\s\s\s\s\s\s+)/', $word);

            foreach ($arrayOfMorze as $code) {

                $sql = "SELECT Betű FROM morze WHERE Morzejel= '$code'";
                $result = mysqli_query($conn, $sql);


                $row = mysqli_fetch_array($result);
                $output .= $row['Betű'];
            }
            $output .= ' ';
        }
    }
    
    
    if (isset($morze2) && array($morze2)) {
        $arrayOfMorze2 = preg_split("/(\s\s\s+|\s\s\s\s\s\s\s+|;)/", $morze2);

        foreach ($arrayOfMorze2 as $code) {

            $sql2 = "SELECT Betű FROM morze WHERE Morzejel= '$code'";
            $result2 = mysqli_query($conn, $sql2);


            $row2 = mysqli_fetch_array($result2);
            print($row2['Betű']);
        }
    }*/
