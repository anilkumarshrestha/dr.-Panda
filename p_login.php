<?php 
require_once 'config.php';
session_start();
if(isset($_SESSION["doctor"])) {
    header("location: index.php");
}
if(isset($_SESSION["patient"])){
    header("location: index.php");
}

$p_username = $password = "";
$p_username_err = $password_err = "";

//processing from data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    //check if p_username field is empty
    if(empty(trim($_POST["p_username"]))){
        $p_username_err = 'Please enter username.';
    } else {
        $p_username = trim($_POST["p_username"]);
    }

    /*
    if(empty(trim($_POST["name"]))){
        $name_err = 'Please enter name.';
    } else {
        $name = trim($_POST["name"]);
    }
    */

    /*
    $address = trim($_POST["address"]);
    $dateofbirth = trim($_POST["dateofbirth"]);
    $gender = trim($_POST["gender"]);
    $phone = trim($_POST["phone"]);
    */

    if(empty(trim($_POST["password"]))){
        $password_err = 'Please enter your password';
    } else {
        $password = trim($_POST["password"]);
    }

    //validate credentials
    if(empty($p_username_err) && empty($password_err)){
        //prepare a select statement
        $sql = "SELECT parti_id, p_username, password FROM patient WHERE p_username = :p_username";   //select column1, column2,.. FROM tablename
        if($stmt = $pdo->prepare($sql)){
            //bind variable to prepared statement as parameters
            $stmt->bindParam(':p_username',$param_p_username, PDO::PARAM_STR);

            //set parameter
            $param_p_username = trim($_POST["p_username"]);

            //attemp to execute the prepared statement
            if($stmt->execute()){
                //p_username exists? verifyPass : err
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $hashed_password = $row['password'];
                        if(password_verify($password,$hashed_password)){
                        //if($password == $hashed_password){
                            //password true
                            session_start();

                            $_SESSION['patient']= $p_username;
				
				
                            $_SESSION['id']= $row["id"];
                            header("location: index.php");
                        } else {
                            $password_err = 'Password Incorrect';
                        }
                    } else {
                        //account False
                        $p_username_err = 'No account found with that p_username.';
                    }
                } else {
                    echo "Something went wrong. Please try again later.";
                }

            }
            //close statement
            unset($stmt);
        }

        //close connection
        unset($pdo);
    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login </title>
   <?php
   include "css.php";
   ?>
</head>
<body>
<div class="container">
   <div class="row">
        <div class="col-xs-4">
            <h2>Participant Login Page</h2>
            <p>Please fill in your credentials to login.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username:<sup>*</sup></label>
                    <input type='text' name='p_username' class='form-control' placeholder="user@xyz.com">
                    <span class="help-block"><?php echo $p_username_err; ?></span>
                </div>

                <div class="form-group">
                    <label>Password:<sup>*</sup></label>
                    <input type='password' name='password' class='form-control' placeholder="password@123...">
                    <span class="help-block"><?php echo $password_err;?></span>
                </div>

                <div class='form-group'>
                    <input type='submit' class='btn btn-primary' value='Submit'>
                </div>

                <p>Do not have an account?<a href="p_register.php">Join today</a>.</p>
                </form>
        </div>
    </div>
</div> <!--container-->
</body>
</html>

