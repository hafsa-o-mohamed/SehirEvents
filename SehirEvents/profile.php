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
        <link rel="stylesheet" type="text/css" href="profile.css" />
        <script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <div class="header">
            <a href="events.php" class="logo">Şehir Events</a>
            <div class="header-right">
                <a class="active" href="Home.php">Home</a>
                <a href="Clubs.php">Clubs</a>
                <a href="Profile.php">My Profile</a>
            </div>
        </div>
        <hr>
    </head>
    <body>
        <div class="wrap">
            <ul class="tabs group">
                <li><a class="active" href="#/one">Profile</a></li>
                <li><a href="#/two">Liked Events</a></li>
                <li><a href="#/three">Researved Events</a></li>
                <li><a href="#/four">Posted Events</a></li>

            </ul>
            <div id="content"> 
                <p class="first" id="one" >
     Name : <?php echo 
    $_SESSION['name'] .' '.$_SESSION['surname'] ?><br> Email <?php echo $_SESSION['email']; ?><br>
     Club :
    <?php 
    $q="
    SELECT club_name
    FROM club
    where club_id=" .$_SESSION['club_id']."";
    $rt = $conn->query($q);
    while ($row=$rt->fetch_assoc()){
        echo "- ". $row['club_name']. "<br> ";
        }

?> 
 </p>
                <p id="two">  
                <?php 
                
$sql="
SELECT title
FROM events
JOIN liked_events
ON events.event_id = liked_events.event_id where liked_events.user_id=".$_SESSION['id']. "";
                //$sql="SELECT * FROM liked_events where user_id=1234 ";
                $resu = $conn->query($sql);
                while ($row=$resu->fetch_assoc()){
                    echo "- ". $row['title']. "<br>";
                    }

?>

                </p>
                <p  id="three">  
                
                <?php 
                
$sl="
SELECT title
FROM events
JOIN reservation
ON events.event_id = reservation.event_id where reservation.user_id=" .$_SESSION['id']. "";
                //$sql="SELECT * FROM liked_events where user_id=1234 ";
                $re = $conn->query($sl);
                while ($row=$re->fetch_assoc()){
                    echo "- " .$row['title']. "<br>";
                    }

?>

                </p>
                <p id="four"></p>
            </div>
        </div>
    </body>

</html>
    <script>

            var tabs = $(".tabs li a");
            tabs.click(function() {
                var content = this.hash.replace('/', '');
                tabs.removeClass("active");
                $(this).addClass("active");
                $("#content").find('p').hide();
                $(content).fadeIn(200);
            });

        (jQuery);
    </script>