<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZGŁOSZNIA</title>
    <link rel="stylesheet" href="styl.css">
</head>

<body>

<?php
    $server = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'zgloszenia';
    
    $connection = mysqli_connect($server, $user, $password, $database);

    if (!$connection) {
        echo 'error';
    }
?>

<header>
    <h1>Zgłoszenia wydarzeń</h1>
</header>

<main>

<section id="blok_lewy">

    <h2>Personel</h2>

    <form method="POST">
        <input type="radio" name="status" id="policjant" value="policjant" checked>
        <label for="policjant">Policjant</label>

        <input type="radio" name="status" id="ratownik" value="ratownik">
        <label for="ratownik">Ratownik</label>

        <button id="select" type="submit">Pokaż</button>
    </form>

<?php
    if (isset($_POST['status'])) {

        $opcje = $_POST['status'];

        echo "<h2>Wybrano opcje: {$opcje}</h2>";

        echo "<div id='teble_center'>";
        echo "<table>";

        echo "<tr>";
        echo "<th>id</th>";
        echo "<th>Imie</th>";
        echo "<th>Nazwisko</th>";
        echo "</tr>";

        $query = "SELECT personel.id, personel.imie, personel.nazwisko
                  FROM personel
                  WHERE personel.status = '{$opcje}'";

        $result = mysqli_query($connection, $query);

        while ($table = mysqli_fetch_row($result)) {

            echo "<tr>";
            echo "<td>$table[0]</td>";
            echo "<td>$table[1]</td>";
            echo "<td>$table[2]</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }
?>

</section>

<section id="blok_prawy">

    <h2>Nowe zgloszenie</h2>

    <ol>

<?php
    $query = "SELECT personel.id, personel.nazwisko
              FROM personel
              WHERE personel.id NOT IN
              (SELECT rejestr.id_personel FROM rejestr)";

    $result = mysqli_query($connection, $query);

    for ($i = 0; $i < mysqli_num_rows($result); $i++) {

        $list = mysqli_fetch_row($result);

        echo "<li>$list[0] $list[1]</li>";
    }
?>

    </ol>

    <form method="POST">

        <label for="inp">Wybierz id osoby:</label>
        <input type="number" id="inp" name="user">

        <button>Dodaj zgloszenie</button>

<?php
    if (isset($_POST['user'])) {

        $id = $_POST['user'];

        $query = "INSERT INTO rejestr(data, id_personel, id_pojazd)
                  VALUES (CURRENT_DATE, '{$id}', 14)";

        $result = mysqli_query($connection, $query);
    }

    mysqli_close($connection);
?>

    </form>

</section>

</main>

<footer>
    <p>Strone <wykonal:0000000000000000></wykonal:0000000000000000>
    </p>
</footer>

</body>
</html>
