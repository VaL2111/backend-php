<?php
$link = mysqli_connect('localhost', 'admin', 'admin');

if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}

mysqli_select_db($link, "StolenCarsDB");

$current_car_id = $_GET['car_id'];

$car_query = "SELECT brand, car_number FROM cars WHERE id = $current_car_id";
$car_result = mysqli_query($link, $car_query);
$car = mysqli_fetch_array($car_result);

echo "<h2>Власник автомобіля " . $car['brand'] . " (" . $car['car_number'] . "):</h2>";

$owner_query = "SELECT * FROM owners WHERE car_id = $current_car_id";
$owner_result = mysqli_query($link, $owner_query);

if (mysqli_num_rows($owner_result) > 0) {
    echo "<table border='1' cellpadding='8' cellspacing='0'>";
    echo "<tr>
            <th>ID Власника</th>
            <th>Прізвище</th>
          </tr>";

    while ($owner = mysqli_fetch_array($owner_result)) {
        echo "<tr>";
        echo "<td>", $owner['id'], "</td>";
        echo "<td>", $owner['surname'], "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>Для цього автомобіля записів про власника ще не знайдено.</p>";
}

echo "<br><br>";
echo "<a href='cars.php'>Повернутися до списку автомобілів</a>";
