<?php
session_start();
include('db.php');
if(isset($_POST['login']))
{
    $uname=$_POST['user'];
    $password=$_POST['pass'];
    $sql ="SELECT user_name,password FROM login WHERE user_name=:uname and password=:password";
    $query= $dbh -> prepare($sql);
    $query-> bindParam(':uname', $uname, PDO::PARAM_STR);
    $query-> bindParam(':password', $password, PDO::PARAM_STR);
    $query-> execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    if($query->rowCount() > 0)
    {
    $_SESSION['alogin']=$_POST['user'];
    echo "<script type='text/javascript'> document.location = 'main/newpatient.php'; </script>";
    } else{
        
        echo "<script>alert('Invalid Details');</script>";

    }

}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/login_css/loginstyle.css">
    <title>Hospital Admin</title>
</head>

<body>
    <div class="login-wrapper">
        <form method="post" class="form">
            <img src="assets/img/avatar1.jpg" alt="">
            <h2>Hospital Admin</h2>
            <div class="input-group">
                <input type="text" name="user" id="loginUser" autocomplete="off" required>
                <label for="loginUser">User Name</label>
            </div>
            <div class="input-group">
                <input type="password" name="pass" id="loginPassword" autocomplete="off" required>
                <label for="loginPassword">Password</label>
            </div>
            <input name="login" type="submit" value="login" class="submit-btn">
        </form>

    </div>
</body>

</html>