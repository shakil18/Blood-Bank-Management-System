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
        add_new_user();
    }

    function add_new_user()
    {
        if(!empty($_POST['name']) && !empty($_POST['password'])) 
        {
            $name = $_POST['name'];
            $password = $_POST['password'];
            
            $conn = oci_connect('system', 'root', 'localhost/orcl');
                
            $query = "INSERT INTO user_info(user_id,username,password) VALUES (nuser.nextval, '$name', '$password')";

               $stid = oci_parse($conn, $query);
               
                $result = oci_execute($stid);
                
                if(!$result) {
                    echo "Failed !";
                }else {
                    echo "Successfully added New User !";
                    header('Location: User.php');
                }

        }else {
            echo "<p id=\"warning\">Fill All The Information !</p>";
        }
    }
?>

<div class="donor-section">
    <h1 class="menu-title">Add New User : </h1>
    <a href="user.php" class="hlink cat-link">Back to User List</a>
    
    <form id="add-donor-form" name="donorform" action="add-user.php" method="post">
       <br>
        <p class="form-text">User Name : </p>
        <input name="name" class="form-field" type="text" placeholder="Name">
        
        <p class="form-text">Password : </p>
        <input name="password" class="form-field" type="password" placeholder="Password">
        
        
        <br>
        <input type="submit" name="submit" id="submit" value="Add New User" class="form-field">
        
    </form>
</div>


<?php require_once('footer.php')?>
