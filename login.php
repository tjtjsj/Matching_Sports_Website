<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE>
<html>
  <body>
<font color="red"><h1> 4K </h1></font>
<font color="black"><h3> SIGN UP TO PLAY SPORTS </h3></font>


    <?php
    session_start();
    $createnewform = '<form method="POST" action ="">
    <table>
        <tr><td>User ID 	</td> <td><input type="text" name ="user_id" id = "user_id"/> </td></tr>
        <tr><td>Username 	</td> <td><input type="text" name ="username" id = "username"/></td></tr>
        <tr><td>Password 	</td> <td><input type="text" name ="password" id = "password"/></td></tr>
        <tr><td>Zipcode  	</td> <td><input type="text" name ="zipcode" id = "zipcode"/></td></tr>
        <tr><td>Phone  		</td> <td><input type="text" name ="phone" id = "phone"/></td></tr>
        <tr><td>Email  		</td> <td><input type="text" name ="email" id = "email"/></td></tr>
        <tr><td>  <input type = "submit" id = "save" name ="save" value="create new user"/></td></tr>
          
          </table>
          </form>';
    $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      //something posted
      if(isset($_POST['save'])){
        $user_id = $_POST["user_id"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $zipcode = $_POST['zipcode'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        if($username == "" || $password == ""){
          echo "invalid name or password";
          echo $createnewform;
          break;
        }
        $sql = "INSERT INTO users (user_id, name, zipcode, phone, email, password)  VALUES('$user_id','$username','$zipcode','$phone', '$email','$password')";
        $checkforuserid = "SELECT * FROM users WHERE user_id = '$user_id'";
        if(mysqli_num_rows(mysqli_query($connection, $checkforuserid)) > 0){
          echo "this user id already exists.";
          echo $createnewform;
          break;
        }

        else if(!mysqli_query($connection, $sql)){
          echo mysqli_error($connection);
        }

        echo "added user <br>";
        header('Location: project.php');
        echo $username;
        echo $sql;
        echo "<br>";
      }



      if (isset($_POST['login'])) {
        echo "login post<br>";
        $user_id = $_POST["user_id"];
        $password = $_POST["password"];
        $sql = "SELECT * FROM users WHERE user_id='".$user_id."' and password='".$password."'";
        $count =  mysqli_num_rows(mysqli_query($connection, $sql));

       if($count != 0){
          echo "logged in";
          $_SESSION['user_id'] = $user_id;
          header('Location: user_mainmenu.php');
        }
       else{

         echo "notfound";
         header('Location: project.php');
          echo mysqli_error($connection);
     }
        echo mysqli_num_rows(mysqli_query($connection, $sql));
          // dologin
      }

      else if (isset($_POST['createNew'])){
          //create new user and save as tuple

          echo $createnewform;


      }
  }

    ?>
  </body>



</html>
