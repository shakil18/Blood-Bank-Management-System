<?php session_start(); ?>
<?php require_once('header.php')?>
<?php require_once('sidebar.php')?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

    global $e;

    if(isset($_REQUEST['e']))
        {
            $e = $_GET['e'];
      }

    if(isset($_POST['submit']))
    {
        add_new_blood();
    }

    function add_new_blood()
    {
        if(!empty($_POST['bamount']) && !empty($_POST['pamount'])) 
        {
            $bamount = $_POST['bamount'];
            $pamount = $_POST['pamount'];

            
            $conn = oci_connect('system', 'root', 'localhost/orcl');
                
            global $e;
            $query = "UPDATE blood SET blood_amount ='$bamount', paid_amount ='$pamount' WHERE blood_id ='$e'";

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully updated Branch !";
                    header('Location: blood.php');
                }

        }else {
            echo "<p id=\"warning\">Fill All The Information !</p>";
        }
    }
?>



<?php

            global $e;
            $conn = oci_connect('system', 'root', 'localhost/orcl');
            if (!$conn) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }
            
            $query = 'SELECT * FROM blood WHERE blood_id ='.$e;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);
            
            while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                
        
 ?>


<div class="donor-section">
    <h1 class="menu-title">Edit Blood : <?php echo $row['BLOOD_GROUP']?></h1>
    <a href="blood.php" class="hlink cat-link">Back to Blood List</a>
    
    <form id="add-donor-form" name="donorform" action="edit-blood.php?e=<?php echo $e; ?>" method="post">
       <br>
        <p class="form-text">Blood Amount : </p>
        <input name="bamount" class="form-field" type="text" placeholder="Amount of Blood" value="<?php echo $row['BLOOD_AMOUNT']?>">
        
        <p class="form-text">Paid Amount : </p>
        <input name="pamount" class="form-field" type="text" placeholder="Amount" value="<?php echo $row['PAID_AMOUNT']?>">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Update Blood" class="form-field">
        
    </form>
    
    
</div>

<?php 
    }
?>

<?php require_once('footer.php')?>
