<?php
$link = mysqli_connect('localhost', 'admin', 'admin');

if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}

$db = "StolenCarsDB";
$select = mysqli_select_db($link, $db);

if ($select) {
    echo "Базу успішно вибрано", "<br>";
} else {
    echo "База не вибрана";
}

$query = "CREATE TABLE cars (
    id INT NOT NULL AUTO_INCREMENT,
    PRIMARY KEY (id),
    car_number VARCHAR(20),
    brand VARCHAR(50),
    status VARCHAR(20)
)";

$create_tbl = mysqli_query($link, $query);

if ($create_tbl) {
    echo "Таблиця cars успішно створена", "<br>";
} else {
    echo "Таблиця не створена: " . mysqli_error($link);
}
