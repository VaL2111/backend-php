<?php
$link = mysqli_connect('localhost', 'admin', 'admin');
if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}
mysqli_select_db($link, "StolenCarsDB");

if (isset($_POST['submit'])) {
    $car_id = $_POST['car_id'];
    $car_number = $_POST['car_number'];
    $brand = $_POST['brand'];
    $status = $_POST['status'];
    $surname = $_POST['surname'];

    $update_car_query = "UPDATE cars SET car_number='$car_number', brand='$brand', status='$status' WHERE id=$car_id";
    mysqli_query($link, $update_car_query);

    $update_owner_query = "UPDATE owners SET surname='$surname' WHERE car_id=$car_id";
    mysqli_query($link, $update_owner_query);

    echo "<p style='color: green;'>Запис успішно змінено!</p>";
}

$current_car_id = isset($_GET['car_id']) ? $_GET['car_id'] : (isset($_POST['car_id']) ? $_POST['car_id'] : 0);

if ($current_car_id > 0) {
    $query_car = "SELECT * FROM cars WHERE id = $current_car_id";
    $result_car = mysqli_query($link, $query_car);
    $edit_car = mysqli_fetch_array($result_car);

    $query_owner = "SELECT * FROM owners WHERE car_id = $current_car_id";
    $result_owner = mysqli_query($link, $query_owner);
    $edit_owner = mysqli_fetch_array($result_owner);
} else {
    die("Помилка: Не вказано ID автомобіля.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Редагування автомобіля</title>
</head>
<body>
<h2>Сторінка редагування запису</h2>

<form name="edit_car" method="post" action="">
    <p>
        <label>Номер автомобіля:</label><br>
        <input type="text" name="car_number" size="20" value="<?php echo $edit_car['car_number']; ?>" required />
    </p>
    <p>
        <label>Марка автомобіля:</label><br>
        <input type="text" name="brand" size="50" value="<?php echo $edit_car['brand']; ?>" required />
    </p>
    <p>
        <label>Прізвище власника:</label><br>
        <input type="text" name="surname" size="50" value="<?php echo $edit_owner['surname']; ?>" required />
    </p>
    <p>
        <label>Стан (поточний: <?php echo $edit_car['status']; ?>):</label><br>
        <select name="status">
            <option value="викрадений" <?php if($edit_car['status'] == 'викрадений') echo 'selected'; ?>>Викрадений</option>
            <option value="знайдений" <?php if($edit_car['status'] == 'знайдений') echo 'selected'; ?>>Знайдений</option>
        </select>
    </p>

    <input type="hidden" name="car_id" value="<?php echo $edit_car['id']; ?>" />

    <p>
        <input type="submit" name="submit" value="Змінити" />
    </p>
</form>

<br>
<a href="cars.php">Повернутися до списку автомобілів</a>
</body>
</html>