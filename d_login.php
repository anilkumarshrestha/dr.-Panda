<?php

	require_once("config.php");
	session_start();
	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if(isset($_GET["logout"])) {
		unset($_SESSION["doctor"]);
		header("location: index.php");
	}

	$loggedin = 0;
	$update = 0;

	if(isset($_SESSION["doctor"])) {
		$loggedin = 1;
		$name = ($_SESSION["doctor"]);
	}
        
        if(isset($_SESSION["patient"])){
            header("location: index.php");
        }

	if(isset($_POST["uname"]) && isset($_POST["pword"])) {
		$username = $_POST["uname"];
		$password = $_POST["pword"];

		$stmt = "SELECT * FROM doctor WHERE d_username ='".$username."'  AND password ='".$password."'";

		$result = $conn->query($stmt);

		if ($result->num_rows === 1) {
			$_SESSION["doctor"]= $username;
                        header("location: index.php");
                        exit;

		} else {
		    echo "The username or password is incorrect.";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Doctor Login </title>
    <?php
    include "css.php";
    ?>
    
    <style type="text/css">
      .bs-example{
      	margin: 20px;
      }
    body{
      padding-top: 70px;
    }
    /*padding*/
    .bpadding{
    margin-top: 10px;
    }
    .bs-example{
      margin: 20px;
    }
    </style>
</head>

<body>
<?php if($loggedin == 0) { ?>
<div class="container">
    <div class="wrapper" style="margin-left:4%;">
       <div class="col-xs-4"> 
        <form action="" method="POST">
            <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username:<sup>*</sup></label>
                <input type="text" name="uname"class="form-control">
            </div>

            <div class="form-group">
                <label>Password:<sup>*</sup></label>
                <input type="password" name="pword" class="form-control">
            </div>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        </div>
    </div>
<?php } else { 
        header("location: index.php ");
    }    
    ?>

<script src="/style/js/jquery.min.js"></script>
<script src="/style/js/bootstrap.min.js"></script>

</div><!--container-->
</body>
</html>

<?php 
$conn->close(); 
?>

