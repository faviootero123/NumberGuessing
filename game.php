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
    <h1>Number guessing game!</h1>
    <p>Guess my secret number which is chosen between 1 and 100!</p>
    <p<?php if(isset($_POST['start_game'])) {echo " style='display: none'"; } else if(isset($_POST['submit_number'])) {echo " style='display: none'"; } ?>>Don't worry, I will tell you if your number is higher or lower than my number.</p>
    <p<?php if(isset($_POST['start_game'])) {echo " style='display: none'"; } else if(isset($_POST['submit_number'])) {echo " style='display: none'"; } ?>> Are you ready?</p>
    <?php
        $counter = 1;

        if (isset($_POST['start_game'])){

            unset($_SESSION["number"]);
            unset($_SESSION["counter"]);
            $_SESSION["number"] = rand(1, 100);
            $_SESSION["counter"] = 1;
            echo "<p>Counter: $counter</p>";

        } else if(isset($_POST['submit_number'])){

            $counter = $_SESSION["counter"];
            $_SESSION["counter"] = $counter + 1;
            $counter = $_SESSION["counter"];
            $numberToGuess = $_SESSION["number"];

            echo "<p>Counter: $counter</p>";

            try {
                $_POST['number_guess'] = (int)$_POST['number_guess'];
            }
            catch (Exception $e) {
                echo "<p>Numbers Only!</p>";
            }

            if ($numberToGuess > $_POST['number_guess']) {
                echo "<p>Higher than <strong>" . $_POST['number_guess'] . "</strong></p>";
            } else if ($numberToGuess < $_POST['number_guess']) {
                echo "<p>Lower than <strong>" . $_POST['number_guess'] . "</strong></p>";
            } else {

                $servername = "sql204.epizy.com";
                $dbusername = "epiz_30809343";
                $dbpassword = "364cQu0DKcISa04";
                $dbname = "epiz_30809343_3750spr22";

                $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "INSERT INTO Scores (s_Username, s_HighScore) VALUES ('$username', '$counter')";

                if ($conn->query($sql) !== TRUE) {
                    $sql = "UPDATE Scores SET s_HighScore = '$counter' WHERE s_Username = '$username';";
                    $conn->query($sql);
                }

                header("Location: highscores.php");

                $conn->close();
            }
        }
    ?>

    <input type="text" class="hide" id="number" name="number_guess" <?php if(isset($_POST['start_game'])) {echo " style='display: inline'"; } else if(isset($_POST['submit_number'])) {echo " style='display: inline'"; }  ?> />
    <input type="submit"  class="button hide" name="submit_number" value="SUBMIT" <?php if(isset($_POST['start_game'])) {echo " style='display: inline'"; } else if(isset($_POST['submit_number'])) {echo " style='display: inline'"; }?> />
    <input type="submit" class="button" name="start_game" value="START" <?php if(isset($_POST['start_game'])) {echo " style='display: none'"; } else if(isset($_POST['submit_number'])) {echo " style='display: none'"; } ?> />

</form>
</body>
</html>