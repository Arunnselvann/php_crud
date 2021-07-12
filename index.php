<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<!-- full php code -->
 
 <?php

//connect to database

$conn = mysqli_connect('localhost', 'root', '', 'company');
if ($conn->connect_error) {
    die ('Connection failed' .$conn->connect_error);
   } else {
       echo '';
   }

// insert data

$nameerr = $emailerr = $emailformat = $designationerr = $passworderr = $passwordstrength =  "";
$errors = array();

if (isset($_POST['submit'])) {
 
    $name = $_POST['name'];
    if (empty($_POST['name'])) {
       $nameerr = '*Name is required.';
       array_push ($errors,$nameerr);
    } else {
        $name = $_POST['name'];
    }

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

    $designation = $_POST['designation'];
    if (empty($_POST['designation'])) {
        $designationerr = '*Designation is required.';
        array_push ($errors,$designationerr);

    } else {
        $designation = $_POST['designation'];
    }
 
    $password = $_POST['password'];
    if (empty($_POST['password'])) {
        $passworderr = '*Password is required.';
        array_push ($errors,$passworderr);

    } else { 
        if (strlen($password) < 8) {
            $passwordstrength = 'Password must be atlest 8 characters.';
            array_push ($errors,$passwordstrength);

        } else {
        $password = $_POST['password'];
      }
    }

    $name = $_POST['name'];
    $email = $_POST['email'];
    $designation = $_POST['designation'];
    $password = $_POST['password'];

// required field


if(count($errors)==0){
$sql = "INSERT INTO employees (name, email, designation, password)
            VALUES ('$name', '$email', '$designation', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo '';
    } else {
        echo 'Error Inserting' .$conn->error;
    }

}
// header("loaction: index.php");
}

// edit 

if(isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = mysqli_query($conn, "SELECT * FROM employees WHERE id =$id");
    
        $row = mysqli_fetch_array($result);
        $id = $row['id'];
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
    }


    $conn = mysqli_connect('localhost','root','','company');

// update

$nameerrmodal = $emailerrmodal = $emailformatmodal = $designationerrmodal = $passworderrmodal = $passwordstrengthmodal =  "";
$error = array();


if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $designation = $_POST['designation'];
    $password = $_POST['password'];
    $conn = mysqli_connect('localhost','root','','company');

    $result = ("UPDATE employees SET name = '$name', email = '$email', designation = '$designation', password = '$password' WHERE id = '$id'");
    if ($conn->query($result) === TRUE ) {  
        echo 'Record updated successfully';
    } else {
        echo 'Update failed';
    }
    $conn->close();

}

// delete

if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn = mysqli_connect('localhost','root','','company');
    $result = mysqli_query($conn,"DELETE FROM employees WHERE id =$id");
}



?>

<h1 class="text-center">Employee Details </h1>



<!-- form on first loaded page -->
    <form class="container card col-lg-3 col-md-12 col-sm-12" method="POST" action="index.php">

<br>
        Name: <br>
        <input type="text" name="name">
        <span class="error"> <p><?php echo $nameerr; ?></p> </span><br>
        E-mail: <br>
        <input type="text" name="email">
        <span class="error"> <p><?php echo $emailerr; echo $emailformat; ?></p> </span><br>
        Designation: <br>
        <input type="text" name="designation">
        <span class="error"> <p><?php echo $designationerr; ?></p> </span><br>
        Password: <br>
        <input type="password" name="password">
        <span class="error"> <p><?php echo $passworderr; echo $passwordstrength; ?></p> </span><br>
        <input type="submit" class="btn btn-primary col-lg-3 col-sm-6 left" name="submit" value="submit"> <br>
        <a class="btn btn-success col-lg-3 col-sm-6 right" href="login.php"> login</a>
        <br>
    </form>  
    <br>

<!-- show table -->

<?php 

    $conn = mysqli_connect('localhost', 'root', '', 'company');
    $result = mysqli_query($conn, "SELECT * FROM employees");
?>

<style>
.error {
    color:red;
}
</style>


<table class="table table-hover table-responsive">
    <thead class="table-light">
        <tr>
            <td> s.no </td>
            <td> Name </td>
            <td> E-Mail </td>
            <td> Designation </td>
            <td> Password </td>
            <td> Action </td>
        </tr>
    </thead>
    <tbody>

        <?php
        $i=0;
            while($row = mysqli_fetch_array($result)):
        $i++;        
        ?>

        <tr>

            <td> <?php echo $i; ?> </td>
            <td> <?php echo $row['name']; ?> </td>
            <td> <?php echo $row['email']; ?> </td>
            <td> <?php echo $row['designation']; ?> </td>
            <td> <?php echo $row['password']; ?> </td>
            <td> <a href="index.php?edit=<?php echo $row['id'];?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#_modal<?php echo $row['id'];?>"> Edit </a>
                <a href="index.php?delete=<?php echo $row['id'];?>" class="btn btn-danger" >Delete</a> </td>


                <!-- modal -->
                <div class="modal fade" id="_modal<?php echo $row['id'];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    <form action="index.php" method="POST">
                    <input type="hidden"  name="id" value="<?php echo $row['id']?>">
                        Name: <input type="text"  name="name" value="<?php echo $row['name']?>">
                        <br> 
                        <br>
                        E-mail: <input type="text"  name="email" value="<?php echo $row['email']?>">
                        <br>
                        <br>
                        Designation:  <input type="text"  name="designation"  value="<?php echo $row['designation']?>">
                        <br>
                        <br>
                        Password: <input type="text" name="password"  value="<?php echo $row['password']?>">
                        <br>
                        <br>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <input type="submit" class="btn btn-primary" name="update" data-bs-dismiss="modal" value="update">
                    </form>
                    </div>
                    <div class="modal-footer">
                        Employee Detail.
                    </div>
                    </div>
                </div>
                </div>
            </tr>
        <?php endwhile; ?>
    </tbody>

</table>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>
</html>