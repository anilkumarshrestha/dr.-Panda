<?php

	require_once("../config.php");


	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addcarosel"])){

		$target_dir = "../images/carousel/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		$uploadOk = 1;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }

		if (file_exists($target_file)) {
		    echo "Sorry, image file already exists.";
		    $uploadOk = 0;
		}

		if ($_FILES["image"]["size"] > 500000) {
		    echo "Sorry, your file is too large.";
		    $uploadOk = 0;
		}

		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
		    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 0;
		}

		if ($uploadOk == 0) {
		    echo "Sorry, your file was not uploaded.";

		} else {
			move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
		}

		$input["image"] = substr(($target_dir . $_FILES["image"]["name"]), 3);

		if($uploadOk === 1) {
			$sql = "INSERT INTO `carousel` (`image`) VALUES ('".$input["image"]."');";
			$result = $conn->query($sql);

		if ($result) {
				echo ("carousel was successfully added.");

		} else {
			echo "not uploaded";
		}
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>ADD CAROUSEL | ADMIN</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/css/bootstrap.css">
	<link rel="stylesheet" href="../style/css/style.css">
	<link rel="stylesheet" href="../style/css/admin.css">
    <script src="/style/js/jquery.min.js"></script>
    <script src="/style/js/bootstrap.min.js"></script>
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
<?php
include "header1.php";
?>
<div class="bs-example">
	<ul class="nav nav-pills">
				<li ><a href="index.php">Admin Home</a></li>
				<li class="active"><a href="addcarousel.php">Add Carousel</a></li>
				<li ><a href="products.php">Add Product</a></li>
				<li><a href="search.php?p=update">Update Product</a></li>
				<li><a href="search.php?p=delete">Delete Product</a></li>
				<li ><a href="vieworders.php">View Orders</a></li>
	</ul>
<div style="margin-left:20%; margin-top:7%">
<div class="cont" style="margin:3px; padding:5px;">
	<h3>ADD carousel:</h3>
	<form method="POST" enctype="multipart/form-data">

			Image: <input type="file" name="image"><br>
			<?php
				echo ('<input type="submit" name="addcarosel" value="Add">');
			?>
	</form>
</div>
</div>
</body>
</html>
<?php $conn->close(); ?>
