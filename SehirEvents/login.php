<?php
   ob_start();
   session_start();
?>
<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname="newschema";
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);    
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    //echo "Connected successfully";
    ?>
<!DOCTYPE html>
<html>

<head>
    <title>Sehir Events</title>
    <link rel="stylesheet" type="text/css" href="Style.css" />
    <link rel="stylesheet" type="text/css" href="form.css" />

    <div class="header">
        <a href="events.php" class="logo">Şehir Events</a>

        <div class="header-right">
            <a class="active" href="Events.php">Home</a>
            <a href="Clubs.php">Clubs</a>
            <?php if (isset($_SESSION["valid"])==true){
                echo "<a href='profile.php'>My Profile</a>";
            }
            else echo "<a href='login.php'>Login</a>";
            ?>

        </div>

    </div>
    <hr>
</head>

<!-- multistep form -->
<?php
if (isset($_POST['next'])){
    $em = $_POST['email'];
    $pw = $_POST['pass'];
    $_SESSION['valid'] = true;

    $sql="SELECT * FROM users WHERE email ='$em' and password = '$pw' ";
    $result = $conn->query($sql);
    if ($row=$result->fetch_assoc()){
        echo "works";
        if($pw == $row['password']){
            echo"working";
            echo 'Your info: '. $row['id'] .' - '. $row['name'] .' '. $row['surname'] .' '. $row['email'] .' '. $row['club_id'] ;
            $_SESSION['id']=$row['id'];
            $_SESSION['name']=$row['name'];
            $_SESSION['surname']=$row['surname'];
            $_SESSION['club_id']=$row['club_id'];
            $_SESSION['email']=$row['email'];
            header("Location: Events.php");
        }else{
            echo 'error';
        }
    }

    // redirect to home page with session on

}
?>
<form id="msform" role = "form"  method = "post" >
    <!-- progressbar -->

    <!-- fieldsets -->
    <fieldset>
        <h2 class="fs-title">Login</h2>
        <input type="text" name="email" placeholder="Email" />
        <input type="password" name="pass" placeholder="Password" />
        <span>or click here to <a href="signup.php">sign-up</a></span>
        <input type="Submit" name="next" class="next action-button" value="Login" />
    </fieldset>

</form>

</html>