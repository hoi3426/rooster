<?php

      session_start();
     // error_reporting(E_ALL ^ E_NOTICE);


      require_once "config.php";

      function get_session_key()
      {
          $randomId = microtime(true) . uniqid();
          $_SESSION['unique_id'] = $randomId;
          return $randomId;
      }

      // kijk of de gebruiker is ingelogd
      if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
      {
          header("location: login.php");
          exit;
      }

      // kijk of de gebruiker admin of user is

     /* if (isset($_SESSION) && $_SESSION['id'] == '1')
      {
        header("location: admin.php");
      }
      else
      {
          header("location: user.php");
      }*/

      ?>
      
      <!DOCTYPE html>
      <html lang="en">
      <head>
          <meta charset="UTF-8">
          <title>Admin Dashboard</title>
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
          <link rel="stylesheet" href="css/style.css">
          <style type="text/css">

              body{ font: 14px sans-serif; text-align: center; }

          </style>
      </head>
      <body>

        <!-- Gebruikersnaam uitprinten -->

          <div class="page-header">
              <h1>Welkom <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>
          </div>
          
        <!-- Labels boven uitgeprinten data -->

          <div class="container">
          <table class="tabel">
                <tr class="kleur">
                  <td>Begintijd</td>
                  <td>Eindtijd</td>
                  <td>Klant</td>
                  <td>Verwijderen</td>
                </tr>     

      <?php

      // Reservering uitprinten in een table
      
      $sql = "SELECT * FROM reserveringen";
      $result = $link->query($sql);

      while ($row = mysqli_fetch_array($result))
      {
          echo "<tr>";
          //echo "<td>" . $row['ID'] . "</td>";
          echo "<td>" . $row['beginTijd'] . "</td>";
          echo "<td>" . $row['eindTijd'] . "</td>";
          echo "<td>" . $row['username'] . "</td>";
          echo "<td><a href='delete.php?did=" . $row['ID'] . "'>Delete</a></td>";
          echo "</tr>";
      }
      ?>

            </table>
            </div>
          </select>
          </form>

        <!-- Formulier om nieuwe werkzaamheden in te vullen -->
        
          <form action="welcome.php" method="post"><b>Start date:</b>
          <input type="datetime-local" id="start" name="startDate" required
            value="<?php echo date('Y-m-d') . date('H:i'); ?>"
            min="2021-15-04T08:30" max="2022-12-11T08:30">

          <label for="end">End date:</label>

          <input type="datetime-local" id="start" name="endDate" required
            value="<?php echo date('Y-m-d') . date('H:i'); ?>"
            min="2021-15-04T08:30" max="2022-12-11 08:30">
            <button type="submit" name="save">Save</button>
      </form>

      <?php


      // Nieuwe reservering in de database zetten
        $username = htmlspecialchars($_SESSION["username"]);
        

      if(isset($_POST['save'])) {
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        
   
        $query = "INSERT INTO reserveringen (beginTijd, eindTijd, username) VALUES('$startDate', '$endDate', '$username')";
        $resul = mysqli_query($link, $query);// or die('Error querying database!');

        if ($resul === false) {
            die(mysqli_error($db));
        }  
        echo 'Succesvol toegevoegd!';
        header('Location: welcome.php');
    }
?>  
        <!-- Uitlog button -->
        <p>
              <a href="logout.php" class="btn btn-danger">Uitloggen</a>
        </p>
      </body>
      </html>

      <!-- Voorkomt dat de pagina dubbele inzendingen verstuurd -->

      <script>
      if ( window.history.replaceState ) {
        window.history.replaceState( null, null, 
        window.location.href );
      }
      </script>