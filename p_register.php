<?php

require_once 'config.php';

$p_email=$password=$confirm_password="";
$email_err=$password_err=$confirm_password_err="";
$contact_num=$contact_num_err="";

$insert = 'y';
if($_SERVER["REQUEST_METHOD"]=="POST"){
    //validate email
    if(empty(trim($_POST["p_email"]))){
        $email_err="Please enter email.";
    }else{
        //prepare a statement
        $sql = "SELECT id FROM patient WHERE p_email = :p_email";
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":p_email",$param_email,PDO::PARAM_STR);
            $param_email = trim($_POST["p_email"]);

            if($stmt->execute()){
                if($stmt->rowCount()==1){
                    $email_err="This email is already taken.";
                    exit;
                }else{
                    $p_email= trim($_POST["p_email"]);
                }
            }else{
                echo "Something went wrong.";
                exit;
            }


        }
        unset($stmt);
    }

    if(empty(trim($_POST["password"]))){
        $password_err="Please enter password.";
    }elseif(strlen(trim($_POST["password"])) < 6){
        $password_err="Password must be atleast 6 characters.";
        $insert='n';
        
    }else{
        $password = trim($_POST['password']);
    }

    //validate confirm password
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err="Enter confirm password.";
    }else{
        $confirm_password=trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = "Password did not match";
            $insert = 'n';
        }
    }


    //php code for name goes here
    $fields = array("p_f_name","contact_num");
    $input = array();
    $err=array();
    foreach ($fields as $field){
        if(empty(trim($_POST[$field]))){
            $err[$field] = 'This field cannot be empty';
        }else{
            $input[$field] = trim($_POST[$field]);
            $err[$field]= '';
        }
    }

    $p_f_name_err = $err["p_f_name"];
    $contact_num_err = $err["contact_num"];

    if (isset($insert) && $insert == 'y'){
        $stmt = $pdo->prepare("INSERT INTO patient(p_email, password, f_name, contact) VALUES(?,?,?,?)");
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(1, $p_email);
        $stmt->bindParam(2, $hashed_pw);
        $stmt->bindParam(3, $input["p_f_name"]);
        $stmt->bindParam(4, $input["contact_num"]);
        

        if(!$stmt->execute()){
            print "Something went wrong try again later.\n";
        }
        header("location: p_login.php");
        exit;
    
    }
    unset($pdo);
    
}
?>




<!DOCTYPE html>
<html>
<head>

<title>Register</title>
    <?php include "css.php";
    ?>
</head>
<body>
<?php include "header.php";
?>
<div class="container">
    <h3>REGISTER</h2>
    <p>Create an account.</p>
    <div class="row">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        
            <div class="form-group <?php echo (!empty($p_f_name_err))? 'has-error':'';?> ">
                <label>First Name:<sup>*</sup></label>
                <input type="text" name="p_f_name" class="form-control" value="<?php echo $p_f_name?>">
                <span class='help-block'><?php echo $p_f_name_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($p_email_err)) ? 'has-error':''; ?>">
                <label>email:<sup>*</sup></label>
                <input type="text" name="p_email" class="form-control" value="<?php echo $p_email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($password_err))? 'has-error':'';?>">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err ?></span>
            </div>

            <div class="form-group <?php echo(!empty($confirm_password_err))?'has-error':'' ?>">
                <label>Confirm Password:<sup>*</sup></label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err ?></span> 
            </div>

            <div class="form-group">
                <label>Contact Number:</label>
                <input type="phone" name="contact_num" class="form-control" value="<?php echo $contact_num ?>" >
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit">
                <input type="reset" class="btn btn-default" value="Reset">
                <p>Already have an account?<a href="p_login.php">Login</a></p>
                </div>
            </form>
        </div>
    </div>
    </body>
    </html>

