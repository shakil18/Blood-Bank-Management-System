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
        
        $query = 'DELETE FROM branch_triger WHERE br_id='.$p;

        $stid = oci_parse($conn, $query);
        oci_execute($stid);
        
        header('Location: logbr.php');
        
    }
?>

<div class="donor-section">
    <h1 class="menu-title">LOG REPORT : (BRANCH)
                
        <?php
                //function

                $conn = oci_connect('system', 'root', 'localhost/orcl');

                $sql = 'Begin :c :=branch_count();End;';

                $stmt = oci_parse($conn,$sql);

                oci_bind_by_name($stmt, ":c", $msg_out,80, SQLT_CHR);

                if(oci_execute($stmt)){
                    print$msg_out;
                }


            ?>

    </h1>
    
    <?php

        $conn = oci_connect('system', 'root', 'localhost/orcl');
        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $stid = oci_parse($conn, 'SELECT * FROM branch_triger');
        oci_execute($stid);

    
        echo '<table class="tbls">
            <tr>
            <td>Action</td>
            <td>Time</td>
            <td>Old Username</td>
            <td>New Username</td>
            <td>Delete</td>
            </tr>';

        while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
            
            echo '<tr>
            <td>'.$row["ACTION"].'</td>
            <td>'.$row["TIME"].'</td>
            <td>'.$row["OLD"].'</td>
            <td>'.$row["NEW"].'</td>
            <td> <a id="delete" onclick="return confirm(\'You Want To Delete This Item ?\');"" href="logbr.php?p='.$row['BR_ID'].'">Delete</a></td>
            </tr>';
        }
     echo '</table>';


    ?>
</div>


<?php require_once('footer.php')?>
