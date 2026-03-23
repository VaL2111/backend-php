<?php
if (isset($_POST['submit'])) {
    $car_number = $_POST['car_number'];
    $brand = $_POST['brand'];
    $status = $_POST['status'];
    $surname = $_POST['surname'];

    if (!empty($car_number) && !empty($brand) && !empty($surname)) {
        $link = mysqli_connect('localhost', 'admin', 'admin');
        if (!$link) {
            die("Помилка підключення: " . mysqli_connect_error());
        }
        mysqli_select_db($link, "StolenCarsDB");

        $query_car = "INSERT INTO cars (car_number, brand, status) 
                      VALUES ('$car_number', '$brand', '$status')";
        $result_car = mysqli_query($link, $query_car);

        if ($result_car) {

            $new_car_id = mysqli_insert_id($link);

            $query_owner = "INSERT INTO owners (surname, car_id) 
                            VALUES ('$surname', $new_car_id)";
            $result_owner = mysqli_query($link, $query_owner);

            if ($result_owner) {
                echo "<p style='color: green;'>Автомобіль та його власника успішно додано до бази!</p>";
            } else {
                echo "<p style='color: red;'>Автомобіль додано, але помилка з власником: " . mysqli_error($link) . "</p>";
            }

        } else {
            echo "<p style='color: red;'>Помилка при додаванні автомобіля: " . mysqli_error($link) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Будь ласка, заповніть усі поля!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Додати інформацію</title>
</head>
<body>
<h2>Додати інформацію про викрадене авто:</h2>

<form name="add_info" method="post" action="">
    <p>
        <label for="car_number">Номер автомобіля:</label><br>
        <input type="text" name="car_number" id="car_number" size="20" required />
    </p>
    <p>
        <label for="brand">Марка автомобіля:</label><br>
        <input type="text" name="brand" id="brand" size="50" required />
    </p>
    <p>
        <label for="surname">Прізвище власника:</label><br>
        <input type="text" name="surname" id="surname" size="50" required />
    </p>
    <p>
        <label for="status">Стан:</label><br>
        <select name="status" id="status">
            <option value="викрадений">Викрадений</option>
            <option value="знайдений">Знайдений</option>
        </select>
    </p>
    <p>
        <input type="submit" name="submit" id="submit" value="Додати в базу" />
    </p>
</form>

<br>
<a href="cars.php">Повернутися до списку автомобілів</a>
</body>
</html>