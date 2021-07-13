<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>

<!-- php code -->

<?php


// connect database

$conn = mysqli_connect('localhost', 'root', '', 'company');
if ($conn->connect_error) {
    die ('Connection failed' .$conn->connect_error);
   } else {
       echo '';
   }

// variables
$email = $password = '';
$emailerr = $emailformat = $passworderr = $passwordstrength = '';
// submit
$emailerr=$passworderr=$passwordstrength=''; 
$errors = array();

if(isset($_POST['submit'])){

   
    
    $email = $_POST['email'];
   
    if (empty($_POST['email'])) {
       $emailerr = '*E-mail is required.';
       array_push ($errors,$emailerr);
    } else {
        if (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
            $emailformat = 'Enter valid email.';
            array_push ($errors,$emailformat);
        } else {
        $email = $_POST['email'];
        }
    }
   

if (empty($_POST['password'])) {
    
    $passworderr = 'Password is required';
    array_push ($errors,$passworderr);
} else { 
    if (strlen($_POST['password']) < 8) {
        $passwordstrength = 'Password must be atlest 8 characters.';
        array_push ($errors,$passwordstrength);
    } else {
    $password = $_POST['password'];
  }
}


//   already user
if(count($errors)==0){
$result = "SELECT * FROM employees WHERE  email='$email' and password='$password'";
$row = $conn->query($result);
if($row->num_rows > 0)
{
echo "Login Successfull ";
header("location:welcome.php");  
	
}
else
{
	echo " ";
}

}
}
?>
<style>
span {
    color:red;
}

</style>


<!-- login form -->
    <br>
    <h2 class="text-center"> Employee Login </h2>
    <br>
    <div class="container">
    <form class="container card col-lg-3 col-md-12 col-sm-12" method="POST" action="login.php">
        <br>
        E-mail: <br>
        <input type="text" name="email">
        <span> <?php echo $emailerr; echo $emailformat ?> </span>
        <br>
        Password: <br>
        <input type="password" name="password">
        <span > <?php echo $passworderr; echo $passwordstrength ?> </span>
        <br>
        <input type="submit" class="btn btn-success col-lg-3" name="submit" value="submit">
        <br>
        If you are not a user register here<a type="submit" href="index.php">register</a>

    </form>    
    </div>
</body>
</html>