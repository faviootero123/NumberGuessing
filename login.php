<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head> 
        <title>Log In Info</title>
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

            input#button {
                padding: 10px 70px;
                background-color: #4E4E50;
                color:white;
            }
        </style>
    </head>

    <body>
        <form method="post">
        <h1>Login</h1>
        <p><input type="text" name="username" id="user_label" placeholder="User Name"/></p>
        <p><input type="password" name="password" id="pass_label" placeholder="Password"/></p>
        <?php
            if(isset($_POST['button'])) {

                $username = $_POST["username"];
                $password = $_POST["password"];

                if ($username == "") {
                    echo "<p>User Name is blank!</p>";
                } else if ($password == "") {
                    echo "<p>Password is blank!</p>";
                } else {

                    $servername = "sql204.epizy.com";
                    $dbusername = "epiz_30809343";
                    $dbpassword = "364cQu0DKcISa04";
                    $dbname = "epiz_30809343_3750spr22";

                    $conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    $sql = "SELECT * FROM User WHERE u_Username = '$username'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();
                        $hashed = hash('sha256', $password . $row["u_Salt"]);

                        if ($row["u_Password"] === $hashed) {
                            $_SESSION["username"] = $username;
                            header("Location: game.php");
                        } else {
                            echo "<p>Incorrect password. Please try again!<p>";
                        }

                    } else {
                        echo "<p>Username does not exist!<p>";
                    }
                    $conn->close();
                }
            }
        ?>
        <input type="submit" id="button" name="button" value="LOGIN"/>
        <p>Don't have an account? <br><a href="signup.php">Sign Up</a></p>
        </form>
    </body>
</html>