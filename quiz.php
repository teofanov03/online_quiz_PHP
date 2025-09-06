<?php
session_start();
include "connection.php";

if(!isset($_SESSION["username"]) || !isset($_SESSION["exam_category"])){
    echo '<script>window.location = "select_exam.php";</script>';
    exit();
}

$questionno = isset($_GET["questionno"]) ? (int)$_GET["questionno"] : 1;
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Quiz - <?php echo $_SESSION["exam_category"]; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css1/bootstrap.min.css">
<link rel="stylesheet" href="css1/font-awesome.min.css">
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="custom.css">
</head>
<body>

<div class="all-content-wrapper">

    <!-- HEADER -->
    <?php include "header.php"; ?>

    <!-- Quiz Wrapper -->
    <div class="white-block quiz-wrapper">

        <div id="countdowntimer">Loading timer...</div>
        <div id="question-area">Loading question...</div>

        <div class="nav-buttons">
            <button class="btn btn-secondary" id="prevBtn" onclick="prevQuestion()">Previous</button>
            <button class="btn btn-primary" id="nextBtn" onclick="nextQuestion()">Next</button>
        </div>

    </div>

   

</div>
 <!-- FOOTER -->
    <?php include "footer.php"; ?>
<script>
let questionno = <?php echo $questionno; ?>;

function loadQuestion(qno){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200){
            if(xhr.responseText.trim() == "over"){
                window.location.href = "result.php";
            } else {
                document.getElementById("question-area").innerHTML = xhr.responseText;
            }
        }
    };
    xhr.open("GET","forajax/load_questions.php?questionno="+qno,true);
    xhr.send();
}

function radioclick(value, qno){
    var xhr = new XMLHttpRequest();
    xhr.open("GET","forajax/save_answer_in_session.php?questionno="+qno+"&value1="+encodeURIComponent(value),true);
    xhr.send();
}

function startTimer(){
    setInterval(function(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function(){
            if(xhr.readyState==4 && xhr.status==200){
                if(xhr.responseText=="00:00:00"){
                    window.location.href = "result.php";
                }
                document.getElementById("countdowntimer").innerHTML = xhr.responseText;
            }
        }
        xhr.open("GET","forajax/load_timer.php",true);
        xhr.send();
    },1000);
}

function nextQuestion(){ questionno++; loadQuestion(questionno); }
function prevQuestion(){ if(questionno>1){ questionno--; loadQuestion(questionno); } }

loadQuestion(questionno);
startTimer();
</script>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
