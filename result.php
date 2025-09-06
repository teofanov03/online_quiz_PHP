<?php
session_start();
include "connection.php";

if(!isset($_SESSION["username"]) || !isset($_SESSION["exam_category"])){
    echo '<script>window.location = "select_exam.php";</script>';
    exit();
}

// Računanje rezultata
$correct = 0;
$wrong = 0;
$count = 0;

if(isset($_SESSION["answer"])){
    $count = mysqli_num_rows(mysqli_query($link,"SELECT * FROM questions WHERE category='$_SESSION[exam_category]'"));
    for($i=1;$i<=$count;$i++){
        $res = mysqli_query($link,"SELECT answer FROM questions WHERE category='$_SESSION[exam_category]' AND question_no=$i");
        $row = mysqli_fetch_assoc($res);
        $answer = $row['answer'] ?? '';
        if(isset($_SESSION['answer'][$i])){
            if($_SESSION['answer'][$i] == $answer){
                $correct++;
            } else {
                $wrong++;
            }
        } else {
            $wrong++;
        }
    }
}

// Snimanje rezultata u bazu
if(isset($_SESSION["exam_start"])){
    $date = date("Y-m-d H:i:s");
    mysqli_query($link,"INSERT INTO exam_results(id,username,exam_type,total_question,correct_answer,wrong_answer,exam_time) 
                       VALUES(NULL,'$_SESSION[username]','$_SESSION[exam_category]','$count','$correct','$wrong','$date')");
    unset($_SESSION["exam_start"]);
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Exam Result - Online Quiz</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css1/bootstrap.min.css">
<link rel="stylesheet" href="css1/font-awesome.min.css">
<link rel="stylesheet" href="custom.css">
</head>
<body>

<div class="all-content-wrapper">

    <!-- HEADER -->
    <?php include "header.php"; ?>

    <!-- Rezultat -->
    <div class="white-block result-wrapper text-center">
        <h2 class="page-title">Exam Results</h2>
        <p>Total Questions: <?php echo $count; ?></p>
        <p>Correct Answers: <?php echo $correct; ?></p>
        <p>Wrong Answers: <?php echo $wrong; ?></p>
        <a href="select_exam.php" class="btn btn-primary mt-3">Take Another Exam</a>
    </div>

   

</div>
<!-- FOOTER -->
    <?php include "footer.php"; ?>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
