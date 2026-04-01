<?php
$link = mysqli_connect('localhost', 'admin', 'admin');
if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}
mysqli_select_db($link, "StolenCarsDB");

echo "<h2>Статистика БД:</h2>";

$query_cars_count = "SELECT COUNT(id) AS total_cars FROM cars";
$result_cars = mysqli_query($link, $query_cars_count);
$row_cars = mysqli_fetch_assoc($result_cars);
echo "<p>Зареєстровано викрадених автомобілів: <b>" . $row_cars['total_cars'] . "</b></p>";

$query_owners_count = "SELECT COUNT(id) AS total_owners FROM owners";
$result_owners = mysqli_query($link, $query_owners_count);
$row_owners = mysqli_fetch_assoc($result_owners);
echo "<p>Зареєстровано власників: <b>" . $row_owners['total_owners'] . "</b></p>";

$query_last_car = "SELECT id, brand, car_number FROM cars ORDER BY id DESC LIMIT 1";
$result_last_car = mysqli_query($link, $query_last_car);
if ($row_last_car = mysqli_fetch_assoc($result_last_car)) {
    echo "<p>Останній доданий автомобіль: <b>" . $row_last_car['brand'] . " (" . $row_last_car['car_number'] . ")</b></p>";
}

$date_array = getdate();

$begin_date = date("Y-m-d", mktime(0, 0, 0, $date_array['mon'], 1, $date_array['year']));
$end_date = date("Y-m-d", mktime(0, 0, 0, $date_array['mon'] + 1, 0, $date_array['year']));

$query_cars_month = "SELECT COUNT(id) AS month_cars FROM cars WHERE created_date >= '$begin_date' AND created_date <= '$end_date'";
$result_cars_month = mysqli_query($link, $query_cars_month);
$row_cars_month = mysqli_fetch_assoc($result_cars_month);
echo "<p>За поточний місяць додано автомобілів: <b>" . $row_cars_month['month_cars'] . "</b></p>";

$query_popular = "SELECT cars.id, cars.brand, cars.car_number 
                  FROM owners, cars 
                  WHERE owners.car_id = cars.id 
                  GROUP BY cars.id 
                  ORDER BY COUNT(owners.id) DESC 
                  LIMIT 0,1";
$result_popular = mysqli_query($link, $query_popular);
if ($row_popular = mysqli_fetch_assoc($result_popular)) {
    echo "<p>Автомобіль з найбільшою кількістю співвласників: <b>" . $row_popular['brand'] . " (" . $row_popular['car_number'] . ")</b></p>";
} else {
    echo "<p>Автомобіль з найбільшою кількістю співвласників: <b>Немає даних</b></p>";
}

echo "<br><br><a href='cars.php'>Повернення на головну сторінку</a>";
