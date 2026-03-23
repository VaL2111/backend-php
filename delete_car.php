<?php
$link = mysqli_connect('localhost', 'admin', 'admin');
if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}
mysqli_select_db($link, "StolenCarsDB");

echo "<h2>Видалення запису</h2>";

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    $delete_owner_query = "DELETE FROM owners WHERE car_id = $car_id";
    mysqli_query($link, $delete_owner_query);

    $delete_car_query = "DELETE FROM cars WHERE id = $car_id";
    $result_car = mysqli_query($link, $delete_car_query);

    if ($result_car) {
        echo "<p style='color: green;'>Автомобіль та інформацію про його власника успішно видалено з бази.</p>";
    } else {
        echo "<p style='color: red;'>Помилка при видаленні: " . mysqli_error($link) . "</p>";
    }
} else {
    echo "<p style='color: red;'>Помилка: Не вказано ID автомобіля для видалення.</p>";
}
?>

<br>
<a href="cars.php">Повернутися до списку автомобілів</a>