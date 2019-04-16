<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE html>
<html>
<body>
<font color="red"><h1> 4K </h1></font>
<font color="orange"><h3> CREATE or FIND GROUP </h3></font>
<a href="user_mainmenu.php">Main Menue</a>
<?php
function RandomString() {
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $charactersLength = strlen($characters);
    $randomString = "";
    for ($i = 0; $i < 5; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function checkid($genID){
    $checkid = "SELECT * FROM matching WHERE group_id='".$genID."'";
    if($result = mysqli_query($connection, $checkid)){
      if(mysqli_num_rows($result) != 0){
        echo "already exists";
        checkid(RandomString());
      }
      else{
        echo "brand new groupid found";
        return $genID;
      }

  }
}


  session_start();
  $user_id = $_SESSION['user_id'];
  // echo $user_id;
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//  $database = mysqli_select_db($connection, DB_DATABASE);

$form = '
          <form method ="POST" action="">
          <table>
            <tr><td>Sport:</td>
              <td><select name = "sport" id = "sport">
                <option value="soccer">Soccer</option>
                <option value="basketball">Basketball</option>
                <option value="baseball">Baseball</option>
              </select></td></tr>
            
            <tr><td>Number of Participants</td><td> <input type ="number" name = "participants" id = "participants"/></td></tr>
            
            <tr><td>Date</td> <td><input type="date" name = "date" id ="date"/></td></tr>
            
            <tr><td>Zipcode</td> <td> <input type="text" id="zipcode" name = "zipcode" /></td></tr>
            </table>
            <input type = "submit" id = "create" name = "create" value="Create Group">
            <input type = "submit" id = "find" name = "find" value="Find Group">
          </form>';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     //something posted
    if(isset($_POST['match'])){
      // do join group
      // echo "match stuff";
      echo $form;
// on submit redirect to group search

    }
// add to group or create new group
    else if(isset($_POST['groupchoice'])){
      $group_id = $_POST['group_name'];
      // echo $group_id;
      $sql = "INSERT INTO matching (user_id, group_id) VALUES('$user_id', '$group_id')";
      if(!mysqli_query($connection, $sql)){
        echo "did not join group";
      }
      else{
        header('Location: user_mainmenu.php');
      }
    }

    else if(isset($_POST['groupcreation'])){
      // $group_id = $_POST['group_name'];
      echo "group creation";
      $group_id = RandomString();
      // $group_id = checkid($group_id);
     

      $fieldid = $_POST['fields'];
      $numPeople = $_SESSION['numpeople'];
      $playdate = $_SESSION['date'];
      // echo $fieldid;
      $getSportsRow = "SELECT * FROM sports WHERE field_id = '$fieldid'";
      $result = mysqli_query($connection, $getSportsRow);

      $row = mysqli_fetch_assoc($result);
      $buildingid = $row['building_id'];
      $sportType = $row['sportsType'];


      $sql = "INSERT INTO team (group_id, sportsType, play_date, play_time, created_date, numofPeople, field_id) VALUES('$group_id', '$sportType', '$playdate', '', '".date('Y-m-d')."', '$numPeople', '$fieldid')";
      $sql2 ="INSERT INTO matching (user_id, group_id) VALUES('$user_id', '$group_id')";

      echo $sql;
      if(!mysqli_query($connection, $sql) || !mysqli_query($connection, $sql2)){
        echo "did not create group";
      }
      else{
        header('Location: user_mainmenu.php');
      }
    }

    // handle finding or creating group
    else if(isset($_POST['create'])){
      // echo "create group";
      $sport = $_POST['sport'];
      $playdate = $_POST['date'];
      $zip = $_POST['zipcode'];
      $numPeople = $_POST['participants'];
      $_SESSION['numpeople'] = $numPeople;
      $_SESSION['date'] = $playdate;
      $sql = "SELECT s.* , b.* FROM sports s inner join building b on s.building_id=b.building_id where s.sportsType='$sport' and b.building_zipcode = '$zip'";
      // $sql = "SELECT * FROM  building WHERE "

      if($result = mysqli_query($connection, $sql)){
        // user is part of a group
        // print table of all groups associated with user

      // display from infromation from TEAM table
        if(mysqli_num_rows($result) > 0){

            echo "<form method = 'POST'><table>";
            while($row = mysqli_fetch_assoc($result)){
            // while($row = $result->fetch_assoc()){
              // $query = "SELECT * FROM team WHERE group_id = '$row['group_id']'";
              // $teamrow = mysqli_fetch_assoc(mysqli_query($connection, $query));
              echo "<tr>";
              // echo "<td>"
              echo "<td><input type = 'radio' name = 'fields' value = '".$row['field_id']."'></td>
                    <td>".$row['building_name']."</td>
                    <td>". $row['field_id'] . "</td>
                    <td> " . $row['building_id']. "</td>";
              // echo "</td>";
              echo "</tr>";
            }

            echo "
            </table>
            <input type = 'submit' name = 'groupcreation' id ='groupcreation' value='Create Group'/>

            </form>";

          }
          else{
            // echo mysqli_error($connection);
            echo "No fields exist for ". $sport .  " at zipcode ". $zip;
            echo $form;
            // echo "did not create group";
          }
      }



    }

    else if (isset($_POST['find'])){
      // echo "find group";
      $sport = $_POST['sport'];
      $playdate = $_POST['date'];
      $zip = $_POST['zipcode'];
      $sql = "SELECT * FROM team WHERE sportsType ='$sport' AND play_date=$playdate";
      if($result = mysqli_query($connection, $sql)){
        // user is part of a group
        // print table of all groups associated with user

      // display from infromation from TEAM table
        if(mysqli_num_rows($result) > 0){

            echo "<form method = 'POST'><table>";
            while($row = mysqli_fetch_assoc($result)){
            // while($row = $result->fetch_assoc()){
              // $query = "SELECT * FROM team WHERE group_id = '$row['group_id']'";
              // $teamrow = mysqli_fetch_assoc(mysqli_query($connection, $query));
              echo "<tr>";
              // echo "<td>"
               echo "<td><input type = 'radio' name = 'group_name' value = '".$row['group_id']."'></td><td>". $row['sportsType'] . "</td><td> " . $row['play_date']. "</td>";
              // echo "</td>";
              echo "</tr>";
            }

            echo "
            </table>
            <input type = 'submit' name = 'groupchoice' id ='groupchoice' value='Choose Group'/>

            </form>";

          }
        else{
          // echo mysqli_error($connection);
          echo "There are no groups playing ". $sport . " on ".$playdate ;
          echo $form;
        }
      }
    }


}

?>
<br>
<br>
<font color="red"><h4> NEED HELP? </h4></font>
<font color="black"><h5>1. Select Sports TYPE </h5></font>
<font color="black"><h5>2. Enter number of PARTICIPANTS </h5></font>
<font color="black"><h5>3. Select DATE </h5></font>
<font color="black"><h5>4. Enter your ZIPCODE to match or find groups near you </h5></font>
<font color="black"><p>    (If you cannot find any groups near you, then create new group!) <p></font>
<font color="black"><h5>5. JOIN or CREATE groups ! ENJOY! </h5></font>

	


</body>
</html>
