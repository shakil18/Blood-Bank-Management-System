<?php session_start(); ?>
<?php require_once('header.php')?>
<?php require_once('sidebar.php')?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

    if(isset($_GET['p']))
    {
        $p = $_GET['p'];
        
        $conn = oci_connect('system', 'root', 'localhost/orcl');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }
        
        $query = 'DELETE FROM donor WHERE d_id='.$p;

        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        
        header('Location: donor.php');
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Donor : </h1>
    <a href="add-donor.php" class="hlink cat-link">Add New Donor</a>
    
    <?php

        $conn = oci_connect('system', 'root', 'localhost/orcl');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM donor');
        oci_execute($stid);

    
        echo '<table class="tbls">
            <tr>
            <td>Name</td>
            <td>Address</td>
            <td>Area</td>
            <td>Sub Area </td>
            <td>Blood Group </td>
            <td>National ID </td>
            <td>Phone </td>
            <td>Email </td>
            <td>Edit </td>
            <td>Delete </td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            
            //Branch
            $con = oci_connect('system', 'root', 'localhost/orcl');
            if (!$con) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            $std = oci_parse($con, 'SELECT * FROM donor WHERE b_id ='.$row['B_ID']);
            oci_execute($std);
            
            while (($branch = oci_fetch_array($std, OCI_BOTH)) != false) {

            echo '<tr>
            <td>'.$row["D_NAME"].'</td>
            <td>'.$row["ADDRESS"].'</td>
            <td>'.$row["AREA"].'</td>
            <td>'.$row["SUBAREA"].'</td>
            <td>'.$row["BLOOD_GROUP"].'</td>
            <td>'.$row["NATIONAL_ID"].'</td>
            <td>'.$row["PHONE"].'</td>
            <td>'.$row["EMAIL"].'</td>
            <td> <a id="edit" href="edit-donor.php?e='.$row['D_ID'].'">Edit</a></td>
            <td> <a id="delete" onclick="return confirm(\'You Want To Delete This Item ?\');" href="donor.php?p='.$row['D_ID'].'">Delete</a></td>
            </tr>';
            }
        }
     echo '</table>';


    ?>
</div>


<?php require_once('footer.php')?>
