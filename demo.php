<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Online Quiz System</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" href="css1/bootstrap.min.css">
    <link rel="stylesheet" href="css1/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">


</head>

<body>

    <div class="all-content-wrapper">

        <div class="header-advance-area">
            <div class="header-top-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="header-top-wraper">
                                <div class="row">
                                    <div class="col-lg-1 col-md-0 col-sm-1 col-xs-12">
                                        <div class="menu-switcher-pro">
                                            <button type="button" id="sidebarCollapse" class="btn bar-button-pro header-drl-controller-btn btn-info navbar-btn">
													<i class="educate-icon educate-nav"></i>
												</button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                                        <div class="header-top-menu tabl-d-n">
                                            <ul class="nav navbar-nav mai-top-nav">
                                                <li class="nav-item"><a href="#" class="nav-link">Select Exam</a>
                                                </li>
                                                <li class="nav-item"><a href="old_exam_result.php" class="nav-link">Last Results</a>
                                                </li>
                                                <li class="nav-item"><a href="logout.php" class="nav-link">Logout</a>
                                                </li>
                                                
                                                
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                                        <div class="header-right-info">
                                            <ul class="nav navbar-nav mai-top-nav header-right-menu">


                                                <li class="nav-item">
                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
															<img src="img/avatar-mini2.jpg" alt="" />
															<span class="admin-name"><?php echo $_SESSION["username"] ?></span>
															<i class="fa fa-angle-down edu-icon edu-down-arrow"></i>
														</a>
                                                    <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">

                                                        
                                                        <li><a href="logout.php"><span class="edu-icon edu-locked author-log-ic"></span>Log Out</a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Menu start -->

            <!-- Mobile Menu end -->
            <div class="breadcome-area">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="breadcome-list">
                                <div class="row">

                                    <div class="col-lg-12 col-md-6 col-sm-6 col-xs-12 text-right">
                                        <ul class="breadcome-menu">
                                            <li><div id="countdowntimer" style=" display:block; "></div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<script type="text/javascript">
function timer(){
    setInterval(function(){
        timer();
    },1000)
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function (){
            if(xmlhttp.readyState==4 && xmlhttp.status==200){
               if(xmlhttp.responseText=="00:00:01"){
                    window.location = "result.php";
                   }
                   document.getElementById("countdowntimer").innerHTML=xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","forajax/load_timer.php", true);
        xmlhttp.open("GET","forajax/set_exam_type_session.php?exam_category=" + exam_category, true);
        xmlhttp.send(null);
 }
</script>

        <div class="row" style="margin: 0px; padding:0px; margin-bottom: 50px;">

            <div class="col-lg-6 col-lg-push-3" style="min-height: 500px; background-color: white;"></div>

        </div>




        <div class="footer-copyright-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="footer-copy-right">
                            <p>Designed and Developed By: Đorđe Teofanov</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="js/vendor/jquery-1.12.4.min.js"></script>
    <script src="js/bootstrap.min.js"></script>


</body>

</html>