<?php include('top.php'); ?>
<?php

// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
// if($_SESSION["loginstatus"]="yes"){
//     header("location: index.php");
//     exit;
// }
 
// Include config file
require_once "function.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        $cn=makeconnection();
        $s="select * from users where Username='" . $_POST["username"] . "' and Pwd='" . $_POST["password"] ."'";
        $q=mysqli_query($cn,$s);
	$r=mysqli_num_rows($q);
$data=mysqli_fetch_array($q);
	mysqli_close($cn);
	if($r>0)
	{
		$_SESSION["Username"]= $_POST["t1"];
		$_SESSION["usertype"]=$data[2];
		$_SESSION['loginstatus']="yes";
		header("location:index.php");
        
                            
    } 
    
        }
                
            else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            
        
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link
        href='http://fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic'
        rel='stylesheet' type='text/css'>

    <!-- <link href="style.css" rel="stylesheet" type="text/css" /> -->
    <link href="../css/style.css" rel="stylesheet" type="text/css" media="all" />
    <style>
    body {
        font: 19px sans-serif;
        display: flex;
        justify-content: center;
    }

    .wrapper {
        width: 360px;
        padding: 20px;
        margin-top: 100px;
    }
    form{
        padding: 20px;
    }
    </style>
</head>

<body>
    <div class="background-img">

        <div class="wrapper" >
            <h2>Admin Login</h2>
            <p>Please fill in your credentials to login.</p>

            <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username"
                        class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                        value="<?php echo $username; ?>">
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password"
                        class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                    <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Login">
                </div>
            </form>
        </div>
    </div>
</body>

</html>