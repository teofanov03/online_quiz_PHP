<?php
session_start();
ob_start(); 
if(!isset($_SESSION["admin_username"])){
    ?>
    <script type="text/javascript">
        window.location = "index.php"
    </script>
    <?php
    exit();
}

include "../connection.php";

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$id1 = isset($_GET["id1"]) ? intval($_GET["id1"]) : 0;

$question = $opt1 = $opt2 = $opt3 = $opt4 = $answer = "";

// Uzimanje podataka
$stmt = $link->prepare("SELECT question, opt1, opt2, opt3, opt4, answer FROM questions WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($question, $opt1, $opt2, $opt3, $opt4, $answer);
$stmt->fetch();
$stmt->close();

if (isset($_POST["submit2"])) {
    $newQuestion = trim($_POST['fquestion']);
    $tm = md5(time());

    // Pomoćna funkcija za upload i update
    function handleUploadAndUpdate($fileKey, $column, $id, $newQuestion, $link, $tm) {
        if (!empty($_FILES[$fileKey]["name"])) {
            $filename = basename($_FILES[$fileKey]["name"]);
            $dst = "./opt_images/" . $tm . $filename;
            $dst_db = "opt_images/" . $tm . $filename;
            move_uploaded_file($_FILES[$fileKey]["tmp_name"], $dst);

            $query = "UPDATE questions SET question = ?, $column = ? WHERE id = ?";
            $stmt = $link->prepare($query);
            $stmt->bind_param("ssi", $newQuestion, $dst_db, $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    // Proveravamo svaki file input
    handleUploadAndUpdate("fopt1", "opt1", $id, $newQuestion, $link, $tm);
    handleUploadAndUpdate("fopt2", "opt2", $id, $newQuestion, $link, $tm);
    handleUploadAndUpdate("fopt3", "opt3", $id, $newQuestion, $link, $tm);
    handleUploadAndUpdate("fopt4", "opt4", $id, $newQuestion, $link, $tm);
    handleUploadAndUpdate("fAnswer", "answer", $id, $newQuestion, $link, $tm);

    // Ako korisnik promeni samo pitanje (bez slika)
    $query = "UPDATE questions SET question = ? WHERE id = ?";
    $stmt = $link->prepare($query);
    $stmt->bind_param("si", $newQuestion, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: add_edit_questions.php?id=$id1&success=1");
    exit();
}
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
                    <h1>Dashboard</h1>
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
                          <div class="col-md-12">
                            <div class="card">
                                <form action="" method="post" name="form1" enctype="multipart/form-data">
                                    <div class="card-body">
                                        <h4 class="card-title text-center mb-4">Update Questions with images</h4>
                                        <?php if(isset($_GET['success']) && $_GET['success']==1): ?>
                                            <div class="alert alert-success">
                                                Question Updated successfully!
                                            </div>
                                        <?php endif; ?>

                                        <div class="form-group">
                                            <label for="question">Question</label>
                                            <input type="text" name="fquestion" id="Question" class="form-control form-control-sm"
                                                placeholder="Add Question" value="<?php echo htmlspecialchars($question); ?>" >
                                        </div>
                                        <div class="form-group">
                                            <img src="<?php echo htmlspecialchars($opt1); ?>" alt="" height="50" width="50"> <br>
                                            <label for="fopt1">Add option 1</label>
                                            <input type="file" name="fopt1" id="fopt1" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                        </div>
                                        <div class="form-group">
                                            <img src="<?php echo htmlspecialchars($opt2); ?>" alt="" height="50" width="50"> <br>
                                            <label for="fopt2">Add option 2</label>
                                            <input type="file" name="fopt2" id="fopt2" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                        </div>
                                        <div class="form-group">
                                            <img src="<?php echo htmlspecialchars($opt3); ?>" alt="" height="50" width="50"> <br>
                                            <label for="fopt3">Add option 3</label>
                                            <input type="file" name="fopt3" id="fopt3" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                        </div>
                                        <div class="form-group">
                                            <img src="<?php echo htmlspecialchars($opt4); ?>" alt="" height="50" width="50"> <br>
                                            <label for="fopt4">Add option 4</label>
                                            <input type="file" name="fopt4" id="fopt4" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                        </div>
                                        <div class="form-group">
                                            <img src="<?php echo htmlspecialchars($answer); ?>" alt="" height="50" width="50"> <br>
                                            <label for="fAnswer">Add Answer</label>
                                            <input type="file" name="fAnswer" id="fAnswer" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                        </div>
                                        <button type="submit" name="submit2" class="btn btn-primary btn-block btn-sm">Update Question</button>
                                    </div>
                                </form>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- .animated -->
    </div><!-- .content -->

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/popper.js/dist/umd/popper.min.js"></script>
    <script src="vendors/jquery-validation/dist/jquery.validate.min.js"></script>
    <script src="vendors/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
