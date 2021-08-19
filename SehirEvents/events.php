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
        <link rel="stylesheet" type="text/css" href="img.css" />


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
<div>
<div class="rightcolumn">
<form id="msform" role = "form" action = "" method = "post">
    <!-- fieldsets -->
    <fieldset id='msform' style="border:none; margin-top:0px;">
        <h2 style= "    font-size: 15px;
    text-transform: uppercase;
    color: #2C3E50;
    margin-bottom: 10px;
    margin-top:0px">Search: </h2>
        <input type="text" name="search" placeholder="What are you looking for?" />
        <input type="date" id="date" name="date">
    </fieldset>

    <fieldset style='border:none; '>
            <div style="display:block;">
                <h2 class="fs-title">Category:</h2>
                <div style="display: fixed;">
                    <h3 class="fs-subtitle"> </h3>
                </div>
                <div style="display: fixed;">
                    <h3 class="fs-subtitle"> </h3>
                    <br>
                </div>
                <div style="display:inline-block;">
                    <select name="category[]" multiple data-placeholder="Select Category">
                    <?php 

$query = "SELECT * FROM category";
$q_result = $conn->query($query);
while ($row_users = mysqli_fetch_array($q_result)) {
    echo "<option>" . $row_users['cat_name']. "</option>";
}

    ?>
               
            </select>
                </div>
            </div>
        </fieldset>

    <fieldset style='border:none; '>
            <div style="display:block;">
                <h2 class="fs-title">search in clubs</h2>
                <div style="display: fixed;">
                    <h3 class="fs-subtitle"> </h3>
                </div>
                <div style="display: fixed;">
                    <h3 class="fs-subtitle"> </h3>
                    <br>
                </div>
                <div style="display:inline-block;">
                    <select name="clubs[]" multiple data-placeholder="search in clubs">
                    <?php 

$sql = "SELECT * FROM club";
$result = $conn->query($sql);
while ($row_users = mysqli_fetch_array($result)) {
    echo "<option>" . $row_users['club_name']. "</option>";
}
    ?>
               
            </select>
                </div>
            </div>
            <input type="Submit" name="submit"  class="next action-button" value="submit" />
        </fieldset>

</form>
</div>

<div class="comments" >
<?php 

if (isset($_POST['submit'])){
    $gt_id="";
    $gt_cid="";
    if (isset($_POST['search'])){
        $search_query=  $_POST['search'];
    }
    if (isset($_POST['date'])){
        $date_query=  $_POST['date'];
    }
    if (isset($_POST['category'])){
        $a[] = '';
        foreach ($_POST['category'] as $selectedCat)
            $a[] = $selectedCat;
        $cat_query=  $a[1];
        $check= "SELECT id FROM category WHERE cat_name LIKE '%$a[1]%'";
        $res = $conn->query($check);
        if ($r=$res->fetch_assoc()){
            $gt_id=$r['id'];
        }
    }
    if (isset($_POST['clubs'])){
        $c[] = '';
        foreach ($_POST['clubs'] as $selectedClub)
            $c[] = $selectedClub;
        $club_query=  $c[1];
        $check_clb= "SELECT club_id FROM club WHERE club_name LIKE '%$c[1]%'";
        $res_club = $conn->query($check_clb);
        if ($r_Club=$res_club->fetch_assoc()){
            $gt_cid=$r_Club['club_id'];
        }
    }
    $s_query= "SELECT * FROM events join category join club on events.host_id = club.club_id and events.cat_id =category.id where title LIKE '%$search_query%' and date LIKE '%$date_query%' and cat_id LIKE '%$gt_id%' and host_id LIKE '%$gt_cid%' ";
    $query_result = $conn->query($s_query);
                while ($row=$query_result->fetch_assoc()){     
                    echo "<sub></sub>";  

                    ?>
                    <figure class="snip1361">
                    <img src="https://images.pexels.com/photos/976866/pexels-photo-976866.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500" alt="sample45" />
                    <figcaption>
                      <h3><?php custom_echo($row['title'], 48);
                      echo "</h3><br>";
                      ?>
                       <?php echo "<p>" .$row['date']."</p>" ; ?>
                      <?php echo "<p>" .$row['cat_name']."</p>" ; ?>
                      <?php echo "<p>Hosted By: " .$row['club_name']."</p>" ; ?>
    
                    </figcaption>
                    <a href="#"></a>
                  </figure>
                  <?php
                }
                        
}
?>
</div>

<?php
    if (isset($_POST['search'])){
        $search_query=  $_POST['search'];
    } 
    else{
?>
<div  class="comments"  >
    <?php 
            $sql = "SELECT * FROM events join category join club on events.cat_id =category.id and events.host_id=club.club_id";
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
</body>

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
    <script>
/* Demo purposes only */
$(".hover").mouseleave(
  function () {
    $(this).removeClass("hover");
  }
);

</script>

</html>