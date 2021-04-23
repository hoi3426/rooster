<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Check of er op de verstuur knop ingedrukt is

if ($_SERVER["REQUEST_METHOD"] == "POST")
{

    if (empty(trim($_POST["username"])))
    {
        $username_err = "Vul een gebruikersnaam in.";
    }
    else
    {

        $sql = "SELECT ID FROM users WHERE username = ?";

        if ($stmt = mysqli_prepare($link, $sql))
        {

            mysqli_stmt_bind_param($stmt, "s", $param_username);

            $param_username = trim($_POST["username"]);

            if (mysqli_stmt_execute($stmt))
            {

                mysqli_stmt_store_result($stmt);

                if (mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "Deze gebruikersnaam is bezet.";
                }
                else
                {
                    $username = trim($_POST["username"]);
                }
            }
            else
            {
                echo "Error, Probeer het opnieuw";
            }

            mysqli_stmt_close($stmt);
        }
    }

    // Wachtwoord checken op verschillende criteria
    if (empty(trim($_POST["password"])))
    {
        $password_err = "Vul een wachtwoord in.";
    }
    elseif (strlen(trim($_POST["password"])) < 6)
    {
        $password_err = "Wachtwoord moet in ieder geval 6 karakters bevatten.";
    }
    else
    {
        $password = trim($_POST["password"]);
    }

    if (empty(trim($_POST["confirm_password"])))
    {
        $confirm_password_err = "Bevestig het wachtwooord.";
    }
    else
    {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password))
        {
            $confirm_password_err = "Wachtwoord is niet gelijk.";
        }
    }

    // Als alles goed is ingevuld, zet de data in de database

    if (empty($username_err) && empty($password_err) && empty($confirm_password_err))
    {

        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";

        if ($stmt = mysqli_prepare($link, $sql))
        {

            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

            $param_username = $username;

            // Wachtwoord Hashen 

            $param_password = password_hash($password, PASSWORD_DEFAULT);

            if (mysqli_stmt_execute($stmt))
            {

                header("location: login.php");
            }
            else
            {
                echo "Error, Probeer het opnieuw.";
            }

            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <style type="text/css">
        body{ font: 14px sans-serif;    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #fff;  }
        .wrapper{ width: 400px; padding: 20px; }
    </style>
</head>
<body>

<!-- Registratie formulier -->

    <div class="wrapper">
        <h2>Account aanmaken</h2>
        <p>Vul het formulier in om een account aan te maken.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Bevestig Wachtwoord</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Versturen">
            
            </div>

            <!-- Login button -->

            <p>Heb je al een account? <a href="login.php">Log hier in</a>.</p>
        </form>
    </div>    
</body>
</html>
