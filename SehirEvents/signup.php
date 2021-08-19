
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
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

            <resource href="https://fonts.googleapis.com/css?family=Roboto:400,500,700">



                <div class="header">
                    <a href="events.php" class="logo">Şehir Events</a>

                    <div class="header-right">
                        <a class="active" href="Home.php">Home</a>
                        <a href="#contact">Clubs</a>
                        <?php if (isset($_SESSION["valid"])==true){
                echo "<a href='profile.php'>My Profile</a>";
            }
            else echo "<a href='login.php'>Login</a>";
            ?>
                    </div>

                </div>
                <hr>
        </head>

        <body>

        <?php

if (isset($_POST['sub'])){
    $em = $_POST['email'];
    $pw = $_POST['pass'];
    $fn = $_POST['fname'];
    $ln = $_POST['lname'];
    $a[] = '';
    foreach ($_POST['clubs'] as $selectedOption)
        $a[] = $selectedOption;
    echo 'Your info: '. $fn .' - '. $ln .' '. $em .' ' ;
    $sql = "SELECT max(id) FROM users";
    $res = $conn->query($sql);
    if ($row=$res->fetch_assoc()){
        print_r( $row);
        $new_id= $row['max(id)']+1;
        }
    else{
            echo 'error';
        }
        $check= "SELECT club_id FROM club WHERE club_name LIKE '%$a[1]%'";
        $res = $conn->query($check);
        if ($r=$res->fetch_assoc()){
            $gt_id=$r['club_id'];
        }
        $sl = "INSERT INTO users (id, name, surname,password,email,club_id)
VALUES ($new_id,'$fn','$ln','$pw','$em',$gt_id)";
    if ($conn->query($sl) === TRUE) {
        echo "New record created successfully";
      } else {
        echo "Error: " . $sl . "<br>" . $conn->error;
      }

    }
    //$_SESSION['valid'] = true;

    

    // redirect to home page with session on



?>
            <!-- multistep form -->
            <form id="msform"  role = "form" action = "" method = "post">
                <!-- progressbar -->
                <ul id="progressbar">
                    <li class="active">Account Setup</li>
                    <li>Personal Details</li>
                    <li>Add Club</li>

                </ul>
                <!-- fieldsets -->
                <fieldset>
                    <h2 class="fs-title">Create your account</h2>
                    <input type="text" name="email" placeholder="Email" />
                    <input type="password" name="pass" placeholder="Password" />
                    <input type="password" name="cpass" placeholder="Confirm Password" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>
                <fieldset>
                    <h2 class="fs-title">Personal Details</h2>
                    <input type="text" name="fname" placeholder="First Name" />
                    <input type="text" name="lname" placeholder="Last Name" />
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="button" name="next" class="next action-button" value="Next" />
                </fieldset>

                <fieldset>
                    <div style="display:block;">
                        <h2 class="fs-title">Add Club</h2>
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
                    <input type="button" name="previous" class="previous action-button" value="Previous" />
                    <input type="Submit" name="sub" class="submit action-button" value="Submit" />
                </fieldset>
            </form>
            <!-- dribbble -->
            <a class="dribbble" href="https://dribbble.com/shots/5112850-Multiple-select-animation-field" target="_blank"><img src="https://cdn.dribbble.com/assets/dribbble-ball-1col-dnld-e29e0436f93d2f9c430fde5f3da66f94493fdca66351408ab0f96e2ec518ab17.png" alt=""></a>
            <script>
                //jQuery time
                var current_fs, next_fs, previous_fs; //fieldsets
                var left, opacity, scale; //fieldset properties which we will animate
                var animating; //flag to prevent quick multi-click glitches

                $(".next").click(function() {
                    if (animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    next_fs = $(this).parent().next();

                    //activate next step on progressbar using the index of next_fs
                    $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

                    //show the next fieldset
                    next_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale current_fs down to 80%
                            scale = 1 - (1 - now) * 0.2;
                            //2. bring next_fs from the right(50%)
                            left = (now * 50) + "%";
                            //3. increase opacity of next_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({
                                'transform': 'scale(' + scale + ')',
                                'position': 'absolute'
                            });
                            next_fs.css({
                                'left': left,
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function() {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                $(".previous").click(function() {
                    if (animating) return false;
                    animating = true;

                    current_fs = $(this).parent();
                    previous_fs = $(this).parent().prev();

                    //de-activate current step on progressbar
                    $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

                    //show the previous fieldset
                    previous_fs.show();
                    //hide the current fieldset with style
                    current_fs.animate({
                        opacity: 0
                    }, {
                        step: function(now, mx) {
                            //as the opacity of current_fs reduces to 0 - stored in "now"
                            //1. scale previous_fs from 80% to 100%
                            scale = 0.8 + (1 - now) * 0.2;
                            //2. take current_fs to the right(50%) - from 0%
                            left = ((1 - now) * 50) + "%";
                            //3. increase opacity of previous_fs to 1 as it moves in
                            opacity = 1 - now;
                            current_fs.css({
                                'left': left
                            });
                            previous_fs.css({
                                'transform': 'scale(' + scale + ')',
                                'opacity': opacity
                            });
                        },
                        duration: 800,
                        complete: function() {
                            current_fs.hide();
                            animating = false;
                        },
                        //this comes from the custom easing plugin
                        easing: 'easeInOutBack'
                    });
                });

                // $(".submit").click(function() {
                //     return false;
                // })
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

        </body>


        </html>