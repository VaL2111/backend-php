<?php
$link = mysqli_connect('localhost', 'admin', 'admin');

if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}

mysqli_select_db($link, "StolenCarsDB");

$query = "SELECT * FROM owners";

$select_owners = mysqli_query($link, $query);

if ($select_owners) {
    echo "<h2>Список власників:</h2>";

    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Прізвище</th>
            <th>ID Автомобіля (car_id)</th>
          </tr>";

    while ($owner = mysqli_fetch_array($select_owners)) {
        echo "<tr>";
        echo "<td>", $owner['id'], "</td>";
        echo "<td>", $owner['surname'], "</td>";
        echo "<td>", $owner['car_id'], "</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Помилка виконання запиту: " . mysqli_error($link);
}

echo "<br><br><a href='cars.php'>Повернення на головну сторінку</a>";
