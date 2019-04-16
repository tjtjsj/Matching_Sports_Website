<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE>
<html>

  <body>
	<font color="red"><h1> 4K </h1></font>
          <font color="black"><h1> RENTAL  </h1></font>

	<font color="black"><h5> DON'T NEED EQUIPMENTS? </h5></font>
	<h3> <a href="user_mainmenu.php">Main Menu</a></h3>
	<font color="darkgreen"><h2> CHOOSE RENTAL EQUIPMENTS</h2></font>

    <?php
    session_start();
    $user_id = $_SESSION['user_id'];
    // echo $_SESSION['user_id'];

    if(isset($_POST['gid'])){
      $_SESSION['group_id'] = $_POST['gid'];
    }
    $gid = $_SESSION['group_id'];

    // echo $gid;
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    // $sql1 = 'SELECT * FROM team';
//     $sql1 = "SELECT e.equip_id, e.building_id, e.Stype
// from sports s inner join team t on s.field_id = t.field_id
//            inner join equipment e on s.building_id = e.building_id
//            where e.available = true and t.group_id= '$gid'";
//  $gid = mysqli_real_escape_string($connection, $gid);
// if(isset($_POST['leave']){
//   $leave = "DELETE FROM matching WHERE user_id = '$user_id' and group_id = '$gid'";
//   echo $leave;
//   // if($r = mysqli_query($connection, $leave)){
//   //   echo "";
//   // }
//   // else{
//   //   mysqli_error($connection);
//   // }
//   // $subtract = "select count(*) from matching where group_id ='$gid'"
//   //
//   header('Location: user_mainmenu.php');
// }

// if remove item, remove rent relation for that equipment id
if (isset($_POST['removing'])){
  $remove = $_POST['remove'];
  $del = "delete from rent where equip_id = '$remove'";
  mysqli_query($connection, $del);
  $changetoTrue = "Update equipment set available = true where equip_id = '$remove'";
  mysqli_query($connection, $changetoTrue);

}

// if rental buttonn was submitted, insert into rent table

if(isset($_POST['renting'])){
  $equipment = $_POST['eid'];
  echo "pressed rent button";
  $changetoFalse = "UPDATE equipment SET available = false WHERE equip_id='$equipment'";
  $r = mysqli_query($connection, $changetoFalse);
  if($r = mysqli_query($connection, $changetoFalse)){
    echo "";
  }
  else{
    echo mysqli_error($connection);
  }
  //
  $rentalInsert = "INSERT INTO rent VALUES ('$equipment', '$user_id', '', '')";
  if($r2 = mysqli_query($connection, $rentalInsert)){
    echo "Succssfully rented equipment";
  }
  else{
    echo mysqli_error($connection);
  }
}

// LIST ALL EQUIPMENT THAT THE USER IS RENTING FOR THIS GROUP
$display_rentals = "SELECT * FROM rent WHERE user_id = '$user_id'";
if($result = mysqli_query($connection, $display_rentals)){
  if(mysqli_num_rows($result) > 0){ // field_id.
    // $fid = mysqli_fetch_assoc($result1);
    echo "<form method ='POST' ><table>";
      while($row = mysqli_fetch_assoc($result)){
        echo "<tr>";
        // echo $row['equip_id'];
         $sql = "Select description from equipment where equip_id = '".$row['equip_id']."'";
         // echo $sql;
         if($descript = mysqli_query($connection, $sql)){
          while($desc = mysqli_fetch_assoc($descript)){
            echo "<td><input type = 'radio' name = 'remove' value = '$row[equip_id]'></td>";
            echo "<td>".$desc['description']. "</td><td>" . $row['equip_id'] . "</td><td> " . $row['building_id'] ."</td>";
          }
        }
        echo "</tr>";

      }

    echo "</table>
    <input type = 'submit' value = 'Remove Rental' id = 'removing' name = 'removing'/>
    </form>";
    // echo "worked ";
  }
  else{
    echo "<br>No equipment rented.";
    echo mysqli_error($connection);
  }
}
else{
  echo "<br>No equipment rented.";
  echo mysqli_error($connection);
}





// LIST ALL AVAILABLE EQUIPMENT FOR RENT
  $sql1 = "SELECT e.equip_id, e.building_id, e.Stype, e.description
          FROM sports s, equipment e, team t
          WHERE s.field_id = t.field_id and s.building_id = e.building_id and e.available = true and t.group_id= '$gid'";
  // $sql1 = mysqli_real_escape_string($connection, $sql1);
  // echo "<br/>$sql1<br/><br/>";
$result1 = mysqli_query($connection, $sql1);
$num = mysqli_num_rows($result1);
// echo "$num<br/>";
  if($result1 = mysqli_query($connection, $sql1)){
      if(mysqli_num_rows($result1) > 0){ // field_id.
        // $fid = mysqli_fetch_assoc($result1);
        echo "<form method ='POST' ><table>";
          while($row = mysqli_fetch_assoc($result1)){
            echo "<tr>";
            echo "<td><input type = 'radio' name = 'eid' value = '$row[equip_id]'></td>";
            echo "<td>" . $row['description']. "</td><td>" . $row['equip_id'] . "</td><td> " . $row['building_id'] ."</td>";
            echo "</tr>";

          }

        echo "</table>
        <input type = 'submit' value = 'Rent Item' id = 'renting' name = 'renting'/>
        </form>";
        // echo "worked ";
      }
      else{
        echo "<br>There is no equipment to rent from this facility.";
        echo mysqli_error($connection);
      }
  }
  else{
    // echo "BOBBFBF<br>";
    echo mysqli_error($connection);
  }

  if(isset($_POST['leave'])){
    $sql = "delete from matching where user_id = '$user_id' and group_id = '$gid'";
    mysqli_query($connection, $sql);
    header('Location: user_mainmenu.php');
  }

     ?>
  </body>
</html>
