<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE>
<html>
  <body>
  	<style>
  		td,tr, table{
  			 border: 1px solid #ddd;
  		}

  	</style>

	<font color="red"><h1> 4K </h1></font>
	<font color="black"><h1>MAIN MENU </h1></font>

	<p> YOUR GROUPS</p>
    <?php
    session_start();
    $user_id = $_SESSION['user_id'];
    // echo $_SESSION['user_id'];


    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    // $sql = "SELECT * FROM matching WHERE user_id = '$user_id'";
    $sql = "SELECT * FROM matching natural join team natural join sports natural join building where matching.user_id = '$user_id'";

    // if(mysqli_num_rows(mysqli_query($connection, $sql) > 0){
    if($result = mysqli_query($connection, $sql)){
      // user is part of a group
      // print table of all groups associated with user

    // display from infromation from TEAM table
      if(mysqli_num_rows($result) > 0){
        echo '<form method="POST" action="rent.php">';
          echo "<table>
          		<th></th>
          		<th>Building</th>
          		<th>Group Id</th>
          		<th>Sport</th>
          		<th>Play Date</th>
          		<th>Created Date</th>
          		";
          while($row = mysqli_fetch_assoc($result)){
          	// $groupinfo = 'SELECT * FROM team WHERE group_id = "'.$row['group_id'].'"';
          	// if($result2 = mysqli_query($connection, $groupinfo)){
          	// 	if(mysqli_num_rows($result2) > 0){
	          // 		while($row2 = mysqli_fetch_assoc($result2)){

		          			echo "<tr>";
				            echo "<td><input type = 'radio' name = 'gid' value = '$row[group_id]'></td>";
				            echo "
				            		<td> " . $row['building_name'] . "</td>
				            		<td>" . $row['group_id']. "</td> 
					            	<td> " . $row['sportsType'] . "</td>
					            	<td> " . $row['play_date'] . "</td>
					            	<td> " . $row['created_date'] . "</td>

				            ";
				            echo "</tr>";
	          // 		}
	          // 	}
          	// }

          // while($row = $result->fetch_assoc()){
            // $query = "SELECT * FROM team WHERE group_id = '$row['group_id']'";
            // $teamrow = mysqli_fetch_assoc(mysqli_query($connection, $query));
            
          }
          echo "</table>";
          echo '<input type="submit" name="leave" id="leave" value="Leave">';
          echo '<input type="submit" name="rent" id="rent" value="Rent">

                </form>';

        }
        else{
          // echo mysqli_error($connection);
          echo "You are not part of any group<br>";
        }
    }


    echo '<form method="POST" action = "group_manager.php">
          <input type = "submit" name = "match" id="match" value = "Join/Create">

          </form>
        ';



    // echo '<form method="POST" action="rent.php">
    //       <input type="submit" name="gid" id="gid" value="Rent">
    //       </form>';

    ?>
  </body>



</html>
