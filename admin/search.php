<?php

	require_once("../config.php");

	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if(isset($_POST["product"])) {
		$productname = trim($_POST["product"]);
		$stmt = "SELECT * FROM products WHERE name LIKE '%".$productname."%'";

		$result = $conn->query($stmt);

		$products = array();
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($products, $row);
			}
		} else {
		    echo "No records found.";
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ADMIN</title>
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
				<li ><a href="addcarosel.php">Add Carousel</a></li>
				<li><a href="products.php">Add Product</a></li>
				<li class="active"><a href="search.php?p=update">Update/Delete Product</a></li>
				<li ><a href="vieworders.php">View Orders</a></li>
	</ul>
</div>

	<div style="margin-left:20%; margin-top:3%">
	<div class="cont" style="margin:3px; padding:5px;">
		<form method="POST" action="<?php if(isset($_GET["p"])) {echo "?" . trim($_GET["p"]);}?>">
			<p>Search Product</p>
				<input type="text" id="product" placeholder="Search" name="product" >
		</form>
		<?php
			if(isset($products) && count($products) != 0) {
				foreach($products as $product) {
			?><div class="product"><img src="<?php echo "../" . $product["image"]; ?>" style="display:inline-block;" width="200"><a style="display:inline-block" href="products.php?view&id=<?php echo $product["id"]; ?>"><?php echo $product["name"]; ?></a></div>
			<?php
				}
			}
		?>
	</div>
</div>
</body>
</html>
