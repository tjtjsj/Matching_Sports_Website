<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php
    session_start();
    $user_id = $_SESSION['user_id'];
    // echo $_SESSION['user_id'];
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();
    $tdate = date("Y/m/d");
    if(isset($_POST['rent'])){
      $sql = "INSERT INTO rent VALUES($_POST['rent'], $user_id, $tdate)";
      $result = mysqli_query($connection, $sql);
    }

    $getinfo = "SELECT * from rent where user_id = $user_id";
    $resultgetinfo = mysqli_query($connection, $getinfo);
    if(mysqli_num_rows($resultgetinfo) > 0){
          echo "<table>";
          while($row = mysqli_fetch_assoc($resultgetinfo)){

            echo "<tr>";
            echo "<td>"$row['equip_id']"'></td> <td> . $row['date'] </td>";
            echo "</tr>";
          }
          echo "</table>";
        }
        else{
          // echo mysqli_error($connection);
          echo "There is no equipment to rent";
        }
     ?>
  </body>
</html>
