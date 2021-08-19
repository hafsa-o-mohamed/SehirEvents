<?php
   ob_start();
   session_start();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Sehir Events</title>
    <link rel="stylesheet" type="text/css" href="Style.css" />
    <link rel="stylesheet" type="text/css" href="Clubs.css" />
    <link rel="stylesheet" type="text/css" href="disply.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <resource href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">
        <div class="header">
            <a href="#default" class="logo">Şehir Events</a>

            <div class="header-right">
                <a class="active" href="events.php">Home</a>
                <a href="Clubs.php">Clubs
                </a><?php if (isset($_SESSION["valid"])==true){
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

<body>
<div>
<?php 

            $sql = "SELECT * FROM club";
            $result = $conn->query($sql);
            while ($row_users = mysqli_fetch_array($result)) {
                //output a row here
                ?>
                </div>
<div class="card">
<?php  echo "<a href=\"clubs-events.php?club=" . urlencode($row_users['club_id']) . "\">" ;
 ?>

<figure class="snip1084 blue">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample43.jpg" alt="sample43" />
    <figcaption>
        <h2>  <?php
                       echo "<h2>"  .$row_users['club_name']. "</h2>" ;
                       echo "        <p>You know what we need, Hobbes? We need an attitude. Yeah, you can't be cool if you.</p>
                       ";

            }
                    ?>
                    </h2>
    </figcaption>

    </a>
</figure>    
</div>
<div class="card">
<?php  echo "<a href=\"clubs-events.php?club=1016\">" ;
 ?>

<figure class="snip1084 blue">
    <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/331810/sample43.jpg" alt="sample43" />
    <figcaption>
        <h2>  <?php
                       echo "<h2>Sehir University</h2>" ;
                       echo "        <p>You know what we need, Hobbes? We need an attitude. Yeah, you can't be cool if you.</p>
                       ";


                    ?>
                    </h2>
    </figcaption>

    </a>
</figure>    
</div>

                    </div>

                    <?php 
function custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}
?>
</body>

</html>

<script>
      /* Demo purposes only */
  $("figure").mouseleave(
    function() {
      $(this).removeClass("hover");
    }
  );
</script>