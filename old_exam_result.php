<?php
session_start();
include "../online_quiz/connection.php";

if(!isset($_SESSION["username"])){
    echo '<script>window.location = "login.php";</script>';
    exit();
}
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Old Exam Results - Online Quiz</title>
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

    <!-- Glavni sadržaj -->
    <div class="white-block">

        <center><h2 class="page-title">Old Exam Results</h2></center>

        <?php
        $stmt = $link->prepare("
            SELECT username, exam_type, total_question, correct_answer, wrong_answer, exam_time 
            FROM exam_results 
            WHERE username = ? 
            ORDER BY id DESC
        ");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $res = $stmt->get_result();
        $count = $res->num_rows;

        if($count === 0){
            echo '<div class="no-results">No Results Found</div>';
        } else {
            echo "<table class='results-table'>";
            echo "<thead>";
            echo "<tr>
                    <th>Username</th>
                    <th>Exam Type</th>
                    <th>Total Questions</th>
                    <th>Correct Answers</th>
                    <th>Wrong Answers</th>
                    <th>Exam Time</th>
                  </tr>";
            echo "</thead>";
            echo "<tbody>";

            while($row = $res->fetch_assoc()){
                echo "<tr>";
                echo "<td>{$row['username']}</td>";
                echo "<td>{$row['exam_type']}</td>";
                echo "<td>{$row['total_question']}</td>";
                echo "<td>{$row['correct_answer']}</td>";
                echo "<td>{$row['wrong_answer']}</td>";
                echo "<td>{$row['exam_time']}</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        }

        $stmt->close();
        ?>

    </div>

    

</div>
<!-- FOOTER -->
    <?php include "footer.php"; ?>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
