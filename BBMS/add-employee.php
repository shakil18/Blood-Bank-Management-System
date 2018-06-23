<?php session_start(); ?>
<?php require_once('header.php')?>
<?php require_once('sidebar.php')?>
<?php
    if(!$_SESSION['user'])
    {
        header('Location: login.php');
    }

        if(isset($_POST['submit']))
    {
        add_new_employee();
    }

    function add_new_employee()
    {
        if(!empty($_POST['name']) && !empty($_POST['salary']) && !empty($_POST['area']) && !empty($_POST['address'])   && !empty($_POST['branch']) && !empty($_POST['role']) && !empty($_POST['phone']) && !empty($_POST['email'])) 
        {
            $name = $_POST['name'];
            $salary = $_POST['salary'];
            $area = $_POST['area'];
            $address = $_POST['address'];
            $branch = $_POST['branch'];
            $role = $_POST['role'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            

            
            $conn = oci_connect('system', 'root', 'localhost/orcl');
                
            $query = "INSERT INTO employee(emp_id, b_id, emp_name, emp_salary, emp_address, emp_area, emp_role, phone, email) VALUES (emp.nextval, $branch, '$name', '$salary', '$address', '$area', '$role', '$phone', '$email')";

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully added New Employee !";
                    header('Location: employee.php');
                }

        }else {
            echo "<p id=\"warning\">Fill All The Information !</p>";
        }
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Add New Employee: </h1>
    <a href="employee.php" class="hlink cat-link">Back to Employee List</a>
    
        <form id="add-donor-form" name="donorform" action="add-employee.php" method="post">
       <br>
        <p class="form-text">Employee Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name">
        
        <p class="form-text">Salary : </p>
        <input name="salary" class="form-field" type="text" placeholder="Salary">
        
        <p class="form-text">Area : </p>
        <input name="area" class="form-field" type="text" placeholder="Area">
        
        <p class="form-text">Address : </p>
        <textarea name="address" id="textarea" class="form-field" cols="30" rows="10" placeholder="Address"></textarea>
        
        <p id="pcat" class="form-text">Select Branch : </p>
             <select name="branch">
                 <?php
                    $conn = oci_connect('system', 'root', 'localhost/orcl');

                   $stid = oci_parse($conn, "SELECT * FROM branch");
                   oci_execute($stid);
                 
                    while (($row = oci_fetch_array($stid, OCI_BOTH)) != false) {
                        echo "<option value=\"".$row['B_ID']."\">".$row['B_NAME']."</option>";
                    }
                 ?>
            </select>
        
        <p class="form-text">Role : </p>
        <input name="role" class="form-field" type="text" placeholder="Role">
        
        <p class="form-text">Phone : </p>
        <input name="phone" class="form-field" type="text" placeholder="Phone">
        
        <p class="form-text">Email : </p>
        <input name="email" class="form-field" type="text" placeholder="Email">
        
        <br>
        <input type="submit" name="submit" id="submit" value="Add New Employee" class="form-field">
        
    </form>
</div>

<?php require_once('footer.php')?>
