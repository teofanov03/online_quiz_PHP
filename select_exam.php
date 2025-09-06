<?php
session_start();
include "connection.php";

if(!isset($_SESSION["username"])){
    echo '<script>window.location = "login.php";</script>';
    exit();
}

$res = mysqli_query($link,"SELECT * FROM exam_category");
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Select Exam - Online Quiz</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css1/bootstrap.min.css">
<link rel="stylesheet" href="css1/font-awesome.min.css">

<link rel="stylesheet" href="custom.css">
</head>
<body>

<div class="all-content-wrapper">

    <!-- HEADER -->
    <?php include "header.php"; ?>

    <!-- MAIN CONTENT -->
    <div class="category-container">

        <h2 class="page-title">Select Exam Category</h2>

        <div class="category-wrapper">
            <?php while($row=mysqli_fetch_assoc($res)): ?>
                <button class="btn btn-primary btn-lg btn-category"
                        onclick="startExam('<?php echo $row['category']; ?>')">
                    <?php echo $row['category']; ?>
                </button>
            <?php endwhile; ?>
        </div>

    </div>

   

</div>
 <!-- FOOTER -->
    <?php include "footer.php"; ?>
<script>
function startExam(category){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(xhr.readyState==4 && xhr.status==200){
            if(xhr.responseText.trim() === "OK"){
                window.location.href = "quiz.php?questionno=1";
            }
        }
    };
    xhr.open("GET", "forajax/set_exam_type_session.php?exam_category="+category, true);
    xhr.send();
}
</script>

<script src="js/vendor/jquery-1.12.4.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
