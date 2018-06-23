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
        
        
        
        //donor-update
        $q_donor = 'UPDATE donor SET b_id = 22 WHERE b_id ='.$p;
        $sdn = oci_parse($conn, $q_donor);
        oci_execute($sdn);

        
        
        //employee
        $q_employee = 'UPDATE employee SET b_id = 22 WHERE b_id ='.$p;
        $se = oci_parse($conn, $q_employee);
        oci_execute($se);

        
        
        //main
        if($p != 22)
        {
            $query = 'DELETE FROM branch WHERE b_id='.$p;

            $stid = oci_parse($conn, $query);
            oci_execute($stid);

            header('Location: branch.php');
        }else {
            echo "<p id=\"warning\">Can't Delete The Main Branch !</p>";
        }
        
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Branch : </h1>
    <a href="add-branch.php" class="hlink cat-link">Add New Branch</a>
    <p style="display: block;">[ You can not delete the Main Branch. Deleting other branch will be set default to Main Branch. ]</p>
    
    
    <?php

        $conn = oci_connect('system', 'root', 'localhost/orcl');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM branch');
        oci_execute($stid);
    
    
    
        echo '<table class="tbls">
            <tr>
            <td>Branch Name</td>
            <td>Address</td>
            <td>Area</td>
            <td>Subarea</td>
            <td>Phone</td>
            <td>Email</td>
            <td>Edit</td>
            <td>Delete</td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            
            echo '<tr>
            <td>'.$row["B_NAME"].'</td>
            <td>'.$row["ADDRESS"].'</td>
            <td>'.$row["AREA"].'</td>
            <td>'.$row["SUBAREA"].'</td>
            <td>'.$row["PHONE"].'</td>
            <td>'.$row["EMAIL"].'</td>
            <td> <a id="edit" href="edit-branch.php?e='.$row['B_ID'].'">Edit</a></td>
            <td> <a id="delete" onclick="return confirm(\'You Want To Delete This Item ?\');" href="branch.php?p='.$row['B_ID'].'">Delete</a></td>
            </tr>';
        }
     echo '</table>';


    ?>
</div>

<?php require_once('footer.php')?>
