

//Login form
<html>
<body>

<form action="" method="post">
    <input type="text" name="username" placeholder="Enter your username" required>
    <input type="password" name="password" placeholder="Enter your password" required>
    <input type="submit" value="Submit">
</form>


// Login request 
<?php

//start first
session_start();

if ( ! empty( $_POST ) ) 
{
    if ( isset( $_POST['username'] ) && isset( $_POST['password'] ) ) 
   {
        $db_host = "localhost";
        $db_name = "lab8";
        $db_user = "root";
        $db_pass = "";

        $con = new mysqli($db_host, $db_user, $db_pass, $db_name);
        $stmt = $con->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_object();
    	
        
    	// Verify user password and set $_SESSION
    	if ( password_verify( $_POST['password'], password_hash($user->password, PASSWORD_DEFAULT) ) ) 
        {
            $_SESSION['user_id'] = $user->ID;
        }
    }
}




?>

</body>
</html> 