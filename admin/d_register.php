
<?php

require_once '../config.php';

    $d_username=$password=$confirm_password="";
    $username_err=$password_err=$confirm_password_err="";
    $contact_num=$contact_num_err="";
    $d_email_err=$d_email="";
    $insert = 'y';
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        //validate username
        if(empty(trim($_POST["d_username"]))){
        $username_err="Please enter Username.";
        } elseif(empty(trim($_POST["d_email"]))) {
                $d_email_err="email cannot be empty";
                } else {
                    //prepare a statement
                    $sql = "SELECT doctor_id FROM doctor WHERE d_username = :d_username";
                    if($stmt = $pdo->prepare($sql)){
                    $stmt->bindParam(":d_username",$param_username,PDO::PARAM_STR);
                    $param_username = trim($_POST["d_username"]);

                    if($stmt->execute()){
                    if($stmt->rowCount()==1){
                        $username_err="This username is already taken.";
                        exit;
                    } else {
                        $d_username= trim($_POST["d_username"]);
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
    } elseif(strlen(trim($_POST["password"])) < 6) {
        $password_err="Password must be atleast 6 characters.";
        $insert='n';
        
    } else {
        $password = trim($_POST['password']);
    }

    //validate confirm password
    if(empty(trim($_POST['confirm_password']))){
        $confirm_password_err="Enter confirm password.";
    } else {
        $confirm_password=trim($_POST['confirm_password']);
        if($password != $confirm_password){
            $confirm_password_err = "Password did not match";
            $insert = 'n';
        }
    }


    //php code for name goes here
    $fields = array("d_email","contact_num");
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
    $contact_num_err = $err["contact_num"];
    
    if (isset($insert) && $insert == 'y'){
        $stmt = $pdo->prepare("INSERT INTO doctor(d_username, password, contact, d_email) VALUES(?,?,?,?)");
        $hashed_pw = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(1, $d_username);
        $stmt->bindParam(2, $password);
        $stmt->bindParam(3, $input["contact_num"]);
        $stmt->bindParam(4, $input["d_email"]);
        

        if(!$stmt->execute()){
            print "Something went wrong try again later.\n";
        }
        header("location: d_login.php");
        exit;
    
    }
    unset($pdo);
    
}
?>


<!DOCTYPE html>
<html>
<head>

<title>Register Doctor </title>
</head>

<body>
<div class="container">
    <h3>Register</h2>
    <p>Create an account.</p>
    <div class="col-xs-6">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group <?php echo (!empty($d_email_err))? 'has-error':'';?> ">
                <label>E-mail:<sup>*</sup></label>
                <input type="text" name="d_email" class="form-control" placeholder="doctormail@xyz.com">
            <span class='help-block'><?php echo $d_email_err; ?></span>
            </div>

            <div class="form-group <?php echo (!empty($d_username_err)) ? 'has-error':''; ?>">
                <label>Username:<sup>*</sup></label>
            <input type="text" name="d_username" class="form-control" value="<?php echo $d_username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
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
            <p>Have no account?<a href="../d_login.php">Login</a></p>
            </div>
        </form>
        </div>
    </div>
    </div>
</div>
</body>
</html>

