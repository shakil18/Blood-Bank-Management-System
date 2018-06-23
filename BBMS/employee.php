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
        
        $query = 'DELETE FROM employee WHERE emp_id='.$p;

        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        
        header('Location: employee.php');
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Employee: 

       <?php
                //function

                $conn = oci_connect('system', 'root', 'localhost/orcl');

                $sql = 'Begin :c :=emp_job_count ();End;';

                $stmt = oci_parse($conn,$sql);

                oci_bind_by_name($stmt, ":c", $msg_out,80, SQLT_CHR);

                if(oci_execute($stmt)){
                    print$msg_out;
                }


            ?>


    </h1>
    <a href="add-employee.php" class="hlink cat-link">Add New Employee</a>
    
    
    
    <?php

        $conn = oci_connect('system', 'root', 'localhost/orcl');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM employee');
        oci_execute($stid);
    
    
    
        echo '<table class="tbls">
            <tr>
            <td>Name</td>
            <td>Salary</td>
            <td>Address</td>
            <td>Area</td>
            <td>Branch</td>
            <td>Role</td>
            <td>Phone</td>
            <td>Email</td>
            <td>Delete</td>
            <td>Edit</td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            
                   //Branch
            $con = oci_connect('system', 'root', 'localhost/orcl');
            if (!$con) {
                $e = oci_error();
                trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            }

            $std = oci_parse($con, 'SELECT b_name FROM branch WHERE b_id ='.$row['B_ID']);
            oci_execute($std);
            
            while (($branch = oci_fetch_array($std, OCI_BOTH)) != false) {
            
            echo '<tr>
            <td>'.$row["EMP_NAME"].'</td>
            <td>'.$row["EMP_SALARY"].'</td>
            <td>'.$row["EMP_ADDRESS"].'</td>
            <td>'.$row["EMP_AREA"].'</td>
            <td>'.$branch["B_NAME"].'</td>
            <td>'.$row["EMP_ROLE"].'</td>
            <td>'.$row["PHONE"].'</td>
            <td>'.$row["EMAIL"].'</td>
            <td> <a id="edit" href="edit-employee.php?e='.$row['EMP_ID'].'">Edit</a></td>
            <td> <a id="delete" onclick="return confirm(\'You Want To Delete This Item ?\');" href="employee.php?p='.$row['EMP_ID'].'">Delete</a></td>
            </tr>';
                
            }

        }
            
     echo '</table>';


    ?>

    
</div>

<?php require_once('footer.php')?>
