<?php
session_start();
include "../connection.php";

if (!isset($_SESSION["admin_username"])) {
    header("Location: index.php");
    exit;
}

if (!isset($_GET["id"]) || !is_numeric($_GET["id"]) || !isset($_GET["id1"]) || !is_numeric($_GET["id1"])) {
    header("Location: exam_category.php");
    exit;
}

$id = intval($_GET["id"]);
$id1 = intval($_GET["id1"]);
$question = $opt1 = $opt2 = $opt3 = $opt4 = $answer = "";

// Uzmi podatke iz baze koristeći prepared statement
$stmt = $link->prepare("SELECT question, opt1, opt2, opt3, opt4, answer FROM questions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($question, $opt1, $opt2, $opt3, $opt4, $answer);
$stmt->fetch();
$stmt->close();
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Panel - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="vendors/selectFX/css/cs-skin-elastic.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
</head>

<body>
<?php include "header.php"; ?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Update Question</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Update Question with text</h4>
                        <form method="post" action="" name="form1">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" name="question" id="Question" class="form-control form-control-sm"
                                       placeholder="Add Question" value="<?php echo htmlspecialchars($question); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="opt1">Add option 1</label>
                                <input type="text" name="opt1" id="opt1" class="form-control form-control-sm"
                                       placeholder="Add option 1" value="<?php echo htmlspecialchars($opt1); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="opt2">Add option 2</label>
                                <input type="text" name="opt2" id="opt2" class="form-control form-control-sm"
                                       placeholder="Add option 2" value="<?php echo htmlspecialchars($opt2); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="opt3">Add option 3</label>
                                <input type="text" name="opt3" id="opt3" class="form-control form-control-sm"
                                       placeholder="Add option 3" value="<?php echo htmlspecialchars($opt3); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="opt4">Add option 4</label>
                                <input type="text" name="opt4" id="opt4" class="form-control form-control-sm"
                                       placeholder="Add option 4" value="<?php echo htmlspecialchars($opt4); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="answer">Add Answer</label>
                                <input type="text" name="answer" id="Answer" class="form-control form-control-sm"
                                       placeholder="Add Answer" value="<?php echo htmlspecialchars($answer); ?>" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-block btn-sm">Update Question</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

<?php 
if (isset($_POST["submit"])) {
    $question = trim($_POST['question']);
    $opt1 = trim($_POST['opt1']);
    $opt2 = trim($_POST['opt2']);
    $opt3 = trim($_POST['opt3']);
    $opt4 = trim($_POST['opt4']);
    $answer = trim($_POST['answer']);

    $stmt = $link->prepare("UPDATE questions SET question = ?, opt1 = ?, opt2 = ?, opt3 = ?, opt4 = ?, answer = ? WHERE id = ?");
    $stmt->bind_param("ssssssi", $question, $opt1, $opt2, $opt3, $opt4, $answer, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: add_edit_questions.php?id=$id1");
    exit;
}
?>
