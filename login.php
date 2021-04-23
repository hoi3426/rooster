<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}
require_once "config.php";
$username = $password = "";
$username_err = $password_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {

    // Als het veld gebruikernsnaam leeg is, geef een error, anders set variable als ingevulde username

    if(empty(trim($_POST["username"]))) {
        $username_err = "Vul een gebruikersnaam in.";
    } else {
        $username = trim($_POST["username"]);
    }
    
    // Als het veld wachtwoord leeg is, geef een error, anders set variable als ingevulde wachtwoord

    if(empty(trim($_POST["password"]))) {
        $password_err = "Vul je wachtwoord in.";
    } else {
        $password = trim($_POST["password"]);
    }
    
     // Als beide checks geen error geven doorsturen naar wacthwoord check

    if(empty($username_err) && empty($password_err)) {

        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)) {

            mysqli_stmt_bind_param($stmt, "s", $param_username);
  
            $param_username = $username;

            if(mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1) {                    
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){

                        // Als het wachtwoord goed  is, zet variablen op de goeden waardes

                        if(password_verify($password, $hashed_password)) {                     
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                                                  
                            header("location: welcome.php");
                        } else {     
                            $password_err = "Onjuist wachtwoord.";
                        }
                    }
                } 
            } else {
                echo "Oops! Something went wrong. Please try again later.";
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
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
</head>
<body>

<!-- login formulier -->

<div class="jumbotron vertical-center"> 
    <div class="container">
        <h2>Inloggen</h2>
        <p>Vul je gegevens in om in te loggen</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="align">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Inloggen">
            </div>

            <!-- Registeer button -->

            <p>Nog geen account? <a href="register.php">Registreer je hier</a>.</p>

        </form>
    </div>   
</div> 
</body>
</html>