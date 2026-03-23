<?php
$link = mysqli_connect("localhost", "root", "");

if (!$link) {
    die("Немає з'єднання з сервером: " . mysqli_connect_error());
}

$query = "GRANT ALL PRIVILEGES ON *.* TO 'admin'@'localhost' IDENTIFIED BY 'admin' WITH GRANT OPTION";

$create_user = mysqli_query($link, $query);

if ($create_user) {
    echo "Користувача admin успішно створено та надано всі привілеї.";
} else {
    echo "Помилка при створенні користувача: " . mysqli_error($link);
}
