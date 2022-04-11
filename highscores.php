<?php
    session_start();
    $username = $_SESSION["username"];
    if ($username == "") {
        header("Location: login.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Game</title>
    <meta charset="utf-8" />
    <style>
        html {
            background: #1A1A1D;
        }

        body {
            background-color: white;
            color: black;
            font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
            margin-left:auto;
            margin-right:auto;
            max-width: 1000px;
            width: 500px;
            text-align: center;
            margin-top: 270px;
            border-radius: 15px;
            padding-bottom: 15px;
        }

        h1 {
            padding: 25px;
            font-size: 30px;
            background-color: #4E4E50;
            border-top-right-radius: 11px;
            border-top-left-radius: 11px;
        }

        p:last-child {
            padding: 20px;
        }

        input {
            background-color: whitesmoke;
            padding: 6px;
            font-family:Cambria, Cochin, Georgia, Times, 'Times New Roman', serif;
        }

        input.button {
            padding: 10px 70px;
            background-color: #4E4E50;
            color:white;
        }

        input.hide {
            display: none;
        }

    </style>
</head>

<body>
<form method="post">
    <h1>TOP 10!</h1>
    <?php

    if (isset($_POST['reset'])){
        header("Location: game.php");
    } else if (isset($_POST['sign_out'])){
        unset($_SESSION["username"]);
        header("Location: login.php");
    } else {

    // server side code
    $servername = "sql204.epizy.com";
    $dbusername = "epiz_30809343";
    $dbpassword = "364cQu0DKcISa04";
    $dbname = "epiz_30809343_3750spr22";

    // Create connection
    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT s_Username, s_HighScore FROM Scores WHERE s_Username = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    echo "<h2>Your Score: " . $row["s_HighScore"] . "</h2>";
    echo "<h3> Username - Score </h3>";

    $sql = "SELECT s_Username, s_HighScore FROM Scores ORDER BY s_HighScore ASC LIMIT 10";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row["s_Username"] . " - " . $row["s_HighScore"] . "<br>";
        }
        echo "<br>";
    } else {
        echo "Got no results.";
    }

    $conn->close();
    }
    ?>

    <input type="submit" name="reset" class="button" value="Play again?"/>
    <input type="submit" name="sign_out" class="button" value="Sign out?"/>

</form>
</body>
</html>