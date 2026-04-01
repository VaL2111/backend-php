<?php
$link = mysqli_connect('localhost', 'admin', 'admin');

if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}

mysqli_select_db($link, "StolenCarsDB");

$query = "SELECT * FROM cars ORDER BY id DESC";

$select_cars = mysqli_query($link, $query);

if ($select_cars) {
    echo "<h2>Список автомобілів:</h2>";

    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>ID</th>
            <th>Номер</th>
            <th>Марка</th>
            <th>Стан</th>
            <th>Дія</th>
          </tr>";

    while ($car = mysqli_fetch_array($select_cars)) {
        echo "<tr>";
        echo "<td>", $car['id'], "</td>";
        echo "<td><a href='car_owner.php?car_id=" . $car['id'] . "'>" . $car['car_number'] . "</a></td>";
        echo "<td>", $car['brand'], "</td>";
        echo "<td>", $car['status'], "</td>";
        echo "<td>
                <a href='edit_car.php?car_id=" . $car['id'] . "'>Редагувати</a>
                <a href='delete_car.php?car_id=" . $car['id'] . "' onclick=\"return confirm('Ви впевнені, що хочете видалити цей автомобіль та інформацію про власника?');\">Видалити</a>
              </td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Помилка виконання запиту: " . mysqli_error($link);
}

echo "<br><br><a href='owners.php'>Список власників</a>";
echo "<br><br><a href='add_car.php'>Додати авто</a>";
echo "<br><br><a href='infor.php'>Статистика БД</a>";
echo "<br><br><a href='search.php'>Пошук</a>";
