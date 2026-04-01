<?php
$link = mysqli_connect('localhost', 'admin', 'admin');
if (!$link) {
    die("Помилка підключення: " . mysqli_connect_error());
}
mysqli_select_db($link, "StolenCarsDB");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Сторінка пошуку</title>
</head>
<body>
<h2>Пошук інформації</h2>

<fieldset style="margin-bottom: 20px;">
    <legend><b>Пошук за маркою або номером автомобіля</b></legend>
    <form name="search_text" method="get" action="">
        Рядок пошуку: <input type="text" name="usersearch" required><br>
        <input type="submit" name="submit_text" value="Search">
    </form>
</fieldset>

<fieldset style="margin-bottom: 20px;">
    <legend><b>Пошук автомобілів за конкретний діапазон дат</b></legend>
    <form name="search_date" method="get" action="">
        З дати: <input type="date" name="date_start" required><br>
        По дату: <input type="date" name="date_end" required><br>
        <input type="submit" name="submit_date" value="Search">
    </form>
</fieldset>

<div style="margin-top: 20px;">
    <?php
    if (isset($_GET['submit_text'])) {
        $search_term = $_GET['usersearch'];
        echo "<h3>Результати пошуку за запитом: '$search_term'</h3>";

        $query = "SELECT * FROM cars WHERE brand LIKE '%$search_term%' OR car_number LIKE '%$search_term%'";
        display_results($link, $query);
    }

    if (isset($_GET['submit_date'])) {
        $start = $_GET['date_start'];
        $end = $_GET['date_end'];
        echo "<h3>Результати пошуку з $start по $end</h3>";

        $query = "SELECT * FROM cars WHERE created_date >= '$start' AND created_date <= '$end'";
        display_results($link, $query);
    }
    function display_results($link, $query) {
        $result = mysqli_query($link, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1' cellpadding='8' cellspacing='0'>";
            echo "<tr><th>ID</th><th>Номер</th><th>Марка</th><th>Стан</th><th>Дата додавання</th></tr>";

            while ($car = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $car['id'] . "</td>";
                echo "<td>" . $car['car_number'] . "</td>";
                echo "<td>" . $car['brand'] . "</td>";
                echo "<td>" . $car['status'] . "</td>";
                echo "<td>" . $car['created_date'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p style='color: red;'>За вашим запитом нічого не знайдено.</p>";
        }
    }
    ?>
</div>

<br><br>
<a href="cars.php">Повернутися на головну сторінку сайту</a> </body>
</html>