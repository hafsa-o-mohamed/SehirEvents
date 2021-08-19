<?php
   ob_start();
   session_start();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Sehir Events</title>
        <link rel="stylesheet" type="text/css" href="Style.css" />
        <link rel="stylesheet" type="text/css" href="Events.css" />

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.28.14/js/jquery.tablesorter.min.js"></script>
        <div class="header">
            <a href="events.php" class="logo">Şehir Events</a>
            <div class="header-right">
                <a class="active" href="events.php">Home</a>
                <a href="Clubs.php">Clubs</a>
                <?php if (isset($_SESSION["valid"])==true){
                echo "<a href='profile.php'>My Profile</a>";
            }
            else echo "<a href='login.php'>Login</a>";
            ?>


            </div>
        </div>
        <hr>
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
    </head>
