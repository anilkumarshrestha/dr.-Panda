<?php

	require_once("config.php");

	$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if(isset($_POST["event_search"])) {
		$eventname = trim($_POST["event_search"]);  //products-->event_search productname-->eventname
		$stmt = "SELECT * FROM event WHERE event_name LIKE '%".$eventname."%'";
		//$stmt = "SELECT * FROM event WITH (INDEX($eventname))";
                $result = $conn->query($stmt);
		$event_search = array();

		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				array_push($event_search, $row);
			}
		} else {
		    echo "No records found.";
		}
	}


?>

<!DOCTYPE HTML>
<html>
<head>
    <title>Event search</title>
    <?php include "css.php";
    ?>
<!--head>
    <style type="text/css">
	.carousel{
	background: #2f4357;
	margin-top: 20px;
	}
	.carousel .item{
	          min-height: 280px; /* Prevent carousel from being distorted if for some reason image doesn't load */
	      }
	      .carousel .item img{
	          margin: 0 auto; /* Align slide image horizontally center */
	      }
	      .bs-example{
	      	margin: 20px;
	      }
	  
	    /*padding*/
	    .bpadding{
	    margin-top: 15px;
	    }
	    .bs-example{
	      margin: 20px;
	    }

	    </style-->

</head>

<body>
    <?php
        include 'header.php';
    ?>
        <div class="container">
            <?php
                    if(isset($event_search) && count($event_search) != 0) {
             ?>
             <div class="row">
             <?php
             foreach($event_search as $event_src) {
                    ?>
                        <div class="col-md-4">
                            <div class="thumbnail">
                                 <a href="event_detail.php?id=<?php echo $event_src["event_id"];?>">
                                        <img class="img-responsive" src="<?php echo "../" . $event_src["image"]; ?>">

                                <p><b><?php echo $event_src["event_name"]; ?></b></p>
                                <p class="price">रू <?php echo $event_src["fees"]; ?></p>
                                </a>
                        
                            <div class="caption">
                                <p><?php echo $event_src["city"];?></p>
                            </div>
                        </div>
                        </div>
                <?php
                    }
        ?>
            </div>
            <?php
            }
            ?>
        </div>
    </body>
    </html>
