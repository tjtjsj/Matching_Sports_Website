<?php include "../inc/dbinfo.inc"; ?>
<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-image: url(image.jpg);
background-size: cover;
    }
  </style>
</head>
<body>
<font color="red"><h1> 4K </h1></font>
<font color="white"><h1> Meet New Friends and Play Sports </h1></font>
<font color="orange"><h3> Join For FREE </h3></font>
  <p class="double">
    <form method="POST" action ="login.php">
        <font color="white"> User ID </font>
        <input type="text" name ="user_id" id = "user_id"/><br>
        <font color="white">Password</font>
        <input type="password" name ="password" id = "password"/>
      <input type ="submit" name = "createNew" id = "createNew" value = "Create New" >
      <input type ="submit" name = "login" id = "login" value = "Login">
    </form>

  </p>
<?php
  $connection = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_errno()) echo "Failed to connect to MySQL: " . mysqli_connect_error();

//  $database = mysqli_select_db($connection, DB_DATABASE);

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     //something posted
//
//     if (isset($_POST['login'])) {
//       echo "login post<br>";
//       $username = $_POST["username"];
//       $password = $_POST["password"];
//       $sql = "SELECT * FROM users WHERE name='".$username."' and password='".$password."'";
//       $count =  mysqli_num_rows(mysqli_query($connection, $sql));
//    if($count != 0){
//       echo "logged in";
//       }
//    else{
//             echo "not found";
//       echo mysqli_error($connection);
//    }
// echo mysqli_num_rows(mysqli_query($connection, $sql));
//         // dologin
//     }
//
//     else if (isset($_POST['createNew'])){
//         //create new user and save as tuple
//         $username = $_POST["username"];
//         $password = $_POST["password"];
//         echo '<input type="text" name ="username" id = "username"/>
//               <input type="text" name ="password" id = "password"/>
//               <input type="text" name ="zipcode" id = "zipcode"/>
//               <input type="text" name ="phone" id = "phone"/>
//               <input type="text" name ="email" id = "email"/>
//               ';
//         if($username == "" || $password == ""){
//           echo "invalid name or password";
//           break;
//         }
//         // $sql = "INSERT INTO users (name, password)  VALUES('$username', '$password')";
//         // if(!mysqli_query($connection, $sql)){
//         //   echo mysqli_error($connection);
//         // }
//         // echo "added user <br>";
//         // echo $username;
//         // echo $sql;
//         echo "<br>";

//     }
// }
?>

