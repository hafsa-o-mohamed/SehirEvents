<?php
   ob_start();
   session_start();
   $club = $_GET["club"]

?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Sehir Events</title>
        <link rel="stylesheet" type="text/css" href="Style.css" />
        <link rel="stylesheet" type="text/css" href="Events.css" />
        <link rel="stylesheet" type="text/css" href="disply.css" />

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
<body>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
  
<!-- The Timeline -->
<!-- Search -->


<?php
    if (isset($_POST['search'])){
        $search_query=  $_POST['search'];
    } 
    else{
?>


<div  class="comments"  >
    <?php 
            $sql = "SELECT * FROM events join category join club on events.cat_id =category.id and events.host_id=club.club_id where club_id = $club ";
            $result = $conn->query($sql);
            while ($row_events = mysqli_fetch_array($result)) {
                echo "<sub></sub>";  

                ?>
                <figure class="snip1361">
                <img src="https://images.pexels.com/photos/976866/pexels-photo-976866.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="sample45" />
                <figcaption>
                  <h3><?php custom_echo($row_events['title'], 48);
                  echo "</h3><br>";
                  ?>
                   <?php echo "<p>" .$row_events['date']."</p>" ; ?>
                  <?php echo "<p>" .$row_events['cat_name']."</p>" ; ?>
                  <?php echo "<p>Hosted By: " .$row_events['club_name']."</p>" ; ?>

                </figcaption>
                <a href="#"></a>
              </figure>
              <?php
            }
        }
                ?>

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

<script>
   $(function(){
  $('#sort').tablesorter(); 
}); 
</script>
<script>
                    function openNav() {
                        var x = document.getElementById("mySidenav");
                        if (x.style.display == "none") {
                            x.style.display = "block";
                        } else {
                            x.style.display = "none";
                        }
                    }
                </script>
                
    <script>
        $(document).ready(function() {

            var select = $('select[multiple]');
            var options = select.find('option');

            var div = $('<div />').addClass('selectMultiple');
            var active = $('<div />');
            var list = $('<ul />');
            var placeholder = select.data('placeholder');

            var span = $('<span />').text(placeholder).appendTo(active);

            options.each(function() {
                var text = $(this).text();
                if ($(this).is(':selected')) {
                    active.append($('<a />').html('<em>' + text + '</em><i></i>'));
                    span.addClass('hide');
                } else {
                    list.append($('<li />').html(text));
                }
            });

            active.append($('<div />').addClass('arrow'));
            div.append(active).append(list);

            select.wrap(div);

            $(document).on('click', '.selectMultiple ul li', function(e) {
                var select = $(this).parent().parent();
                var li = $(this);
                if (!select.hasClass('clicked')) {
                    select.addClass('clicked');
                    li.prev().addClass('beforeRemove');
                    li.next().addClass('afterRemove');
                    li.addClass('remove');
                    var a = $('<a />').addClass('notShown').html('<em>' + li.text() + '</em><i></i>').hide().appendTo(select.children('div'));
                    a.slideDown(400, function() {
                        setTimeout(function() {
                            a.addClass('shown');
                            select.children('div').children('span').addClass('hide');
                            select.find('option:contains(' + li.text() + ')').prop('selected', true);
                        }, 500);
                    });
                    setTimeout(function() {
                        if (li.prev().is(':last-child')) {
                            li.prev().removeClass('beforeRemove');
                        }
                        if (li.next().is(':first-child')) {
                            li.next().removeClass('afterRemove');
                        }
                        setTimeout(function() {
                            li.prev().removeClass('beforeRemove');
                            li.next().removeClass('afterRemove');
                        }, 200);

                        li.slideUp(400, function() {
                            li.remove();
                            select.removeClass('clicked');
                        });
                    }, 600);
                }
            });

            $(document).on('click', '.selectMultiple > div a', function(e) {
                var select = $(this).parent().parent();
                var self = $(this);
                self.removeClass().addClass('remove');
                select.addClass('open');
                setTimeout(function() {
                    self.addClass('disappear');
                    setTimeout(function() {
                        self.animate({
                            width: 0,
                            height: 0,
                            padding: 0,
                            margin: 0
                        }, 300, function() {
                            var li = $('<li />').text(self.children('em').text()).addClass('notShown').appendTo(select.find('ul'));
                            li.slideDown(400, function() {
                                li.addClass('show');
                                setTimeout(function() {
                                    select.find('option:contains(' + self.children('em').text() + ')').prop('selected', false);
                                    if (!select.find('option:selected').length) {
                                        select.children('div').children('span').removeClass('hide');
                                    }
                                    li.removeClass();
                                }, 400);
                            });
                            self.remove();
                        })
                    }, 300);
                }, 400);
            });

            $(document).on('click', '.selectMultiple > div .arrow, .selectMultiple > div span', function(e) {
                $(this).parent().parent().toggleClass('open');
            });

        });
    </script>

</html>