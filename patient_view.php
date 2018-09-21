<?php
require_once"config.php";
session_start();
?>



<?php 


    $stmt = $pdo->prepare("SELECT * FROM report");

if (!$stmt->execute()){
    print "Database error.";
    exit;
}
?>
<?php
$i = 0;
while ($row = $stmt->fetch()){
?>
    <?php if ($i % 3 == 0) { ?>
    <div class="row">
    <?php
    } ?>


    <?php $i += 1; ?>
    <div class="col-md-4">

        <div class="thumbnail"> 
                <a href="<?php echo $row["report"]; ?>">Download report</a>
                <p><?php echo $row["prescription"]; ?></p>
                <p>Date of Check-up: <?php echo $row["date"]; ?></p>
                </div>
            </div>
        </div>
    <?php if ($i % 3 == 0) { ?>
    </div>
    <?php } ?>
<?php
}
?>
</div>

