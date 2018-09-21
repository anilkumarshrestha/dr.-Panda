<?php
	require_once("config.php");
	session_start();

	if(isset($_SESSION["doctor"])) {
		$loggedin = 1;
		$name = ($_SESSION["doctor"]);
	}


        if($_SERVER["REQUEST_METHOD"]=="POST"){
           $fields = array('p_id','checked_date','prescription','doctor_name');
            $input = array();
            foreach($fields as $field){
                if(!empty(trim($_POST["$field"]))){
                $input[$field]=trim($_POST[$field]);
                }
            }
            

            if(!file_exists('report/'.$input['p_id'])){
                mkdir('report/'.$input['p_id'].'',0777,true);
            }
            $target_dir='report/'.$input['p_id'].'/';
            
            // get next auto increment
            $stmt = $pdo->prepare("SHOW TABLE STATUS LIKE 'report'");
            $stmt->execute();
            $single_row = $stmt->fetch();
            $next_eid = $single_row["Auto_increment"];

            $target_file = $target_dir . "ev_rep_". $next_eid . basename($_FILES["file"]["name"]);
            print $target_file;

            $uploadOk = 1;            
            
            if (file_exists($target_file)) {
                echo "Sorry, report file already exists.";
                $uploadOk = 0;
             }
             

	    if ($uploadOk == 0) {
		echo "Sorry, your file was not uploaded.";

	    } else {
		    move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
	            echo "OK Uploaded";
            }
            
	    $input["file"] = $target_dir . "ev_rep_". $next_eid . basename($_FILES["file"]["name"]);
            
	    if($uploadOk === 1) {

                
                
                

            /*$targetfolder = "report/";

             $targetfolder = $targetfolder . basename( $_FILES['file']['name']) ;

            if(move_uploaded_file($_FILES['file']['tmp_name'], $targetfolder))

             {

             echo "The file ". basename( $_FILES['file']['name']). " is uploaded";

             }

             else {

             echo "Problem uploading file";

             }
*/
             
                
                
                
                
                $stmt= $pdo->prepare("INSERT INTO `report` (`p_id`, `date`, `prescription`, `doctor_name`, `report`) VALUES (?, ?,?, ?, ?);");
                
                $stmt->bindParam(1,$input["p_id"]);
                $stmt->bindParam(2,$input["date"]);
                $stmt->bindParam(3,$input["priscription"]);
                $stmt->bindParam(4,$input["doctor_name"]);
                $stmt->bindParam(6,$input["report"]);
		$result = $stmt->execute();
                
                if ($result) {
		        echo "index.php";
                } else {
		    echo "There was a problem creating event.";
		}
	    }

        }
        
?>

<html>

<head>
<?php include "css.php";
?>
<style>
body{
    background-color:  #d4d4aa;
}
</style>
<?php 
include "header.php";
?>


<body>

<?php 
if($loggedin == 1){ ?>
<div class="container">
    <div class="row">
        <div class="col-xs-4">
            <h2>Add Patient</h2>
            <form class="form-horizontal" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Patient ID:</label>
                <input type="" name="p_id" class="form-control" placeholder="patient number">
            </div>

            <div class="form-group">
                <label>Checked Date:</label><input class="form-control" type="date" name="checked_date" placeholder="2018-07-15"/>
            </div>

            <div class="form-group">
                <label>Prescription:</label>
                <input type="text" class="form-control" name="priscription" placeholder="">
            </div>


            <div class="form-group">
                <label>Doctor's Name:</label>
                <input readonly type="text" name="doctor_name"class="form-control" value="<?php echo $name?>"></input>
            </div>
    
            <div class="form-group">
                <input type="hidden" name="" value="">
                <label>Report:</label> 
                <input type="file"class="" name="file">
            </div>
    
            <div class="form-group">
                <input class="btn btn-primary" type="submit" value = "Submit">
            </div>

        </form>
    </div>
<?php }else{
        echo "You must be logged in.";
	header("location: d_login.php");

} ?>
    <div class="col-xs-2">
    </div>
    <div class="col-xs-6">
      <h2>
            Let's get started.
      <h2>
      <img width="400" src="">
    </div>
  </div>
</div> <!--for container-->
</body>
</html>

