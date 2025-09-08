<!DOCTYPE html>
<html>
<head>
    <title>GET METHOD</title>
</head>
<body>
    <h2>Enter Your Information</h2>

    <form method="get">
        <!-- Name -->
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br><br>

        <!-- Age -->
        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required>
        <br><br>

        <!-- Year -->
        <label for="year">Year:</label>
        <input type="number" name="year" id="year" required>
        <br><br>


        <input type="submit" value="Submit">
    </form>

    <hr>
    
    <?php
    if (isset($_GET['name']) && isset($_GET['age']) && isset($_GET['year'])) {
        $name = htmlspecialchars($_GET['name']);
        $age = htmlspecialchars($_GET['age']);
        $year = htmlspecialchars($_GET['year']);

        echo "<h3>Submitted Information:</h3>";
        echo "Hello, <b>$name</b>!<br>";
        echo "You are <b>$age</b> years old.<br>";
        echo "You are currently in <b>Year $year</b>.<br>";
    }
    ?>
</body>
</html>