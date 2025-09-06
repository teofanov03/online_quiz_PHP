<?php
ob_start();
session_start();
include "../connection.php";
if(!isset($_SESSION["admin_username"])){
    ?>
    <script type="text/javascript">
        window.location = "index.php"
    </script>
    <?php
}
$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$exam_category = "";

// Dohvati kategoriju
$stmt = $link->prepare("SELECT category FROM exam_category WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($row = $res->fetch_assoc()) {
    $exam_category = $row["category"];
}
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
                <h1>Add Question inside <?php echo htmlspecialchars($exam_category); ?></h1>
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
                      <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center mb-4">Add New Questions with text</h4>
                                <form method="post" action="" name="form1" enctype="multipart/form-data">
                                    <?php if(isset($_GET['success']) && $_GET['success']==1): ?>
                                    <div class="alert alert-success">
                                        Question added successfully!
                                    </div>
                                    <?php endif; ?>
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <input type="text" name="question" id="Question" class="form-control form-control-sm"
                                               placeholder="Add Question" >
                                    </div>
                                    <div class="form-group">
                                        <label for="opt1">Add option 1</label>
                                        <input type="text" name="opt1" id="opt1" class="form-control form-control-sm"
                                               placeholder="Add option 1" >
                                    </div>
                                    <div class="form-group">
                                        <label for="opt2">Add option 2</label>
                                        <input type="text" name="opt2" id="opt2" class="form-control form-control-sm"
                                               placeholder="Add option 2" >
                                    </div>
                                    <div class="form-group">
                                        <label for="opt3">Add option 3</label>
                                        <input type="text" name="opt3" id="opt3" class="form-control form-control-sm"
                                               placeholder="Add option 3" >
                                    </div>
                                    <div class="form-group">
                                        <label for="opt4">Add option 4</label>
                                        <input type="text" name="opt4" id="opt4" class="form-control form-control-sm"
                                               placeholder="Add option 4" >
                                    </div>
                                    <div class="form-group">
                                        <label for="Answer">Add Answer</label>
                                        <input type="text" name="Answer" id="Answer" class="form-control form-control-sm"
                                               placeholder="Add Answer" >
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary btn-block btn-sm">Update Exam</button>
                                </form>
                            </div>
                        </div>
                      </div> 

                      <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title text-center mb-4">Add New Questions with images</h4>
                                <?php if(isset($_GET['success']) && $_GET['success']==1): ?>
                                <div class="alert alert-success">
                                    Question added successfully!
                                </div>
                                <?php endif; ?>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="question">Question</label>
                                        <input type="text" name="fquestion" id="Question" class="form-control form-control-sm"
                                               placeholder="Add Question" >
                                    </div>
                                    <div class="form-group">
                                        <label for="fopt1">Add option 1</label>
                                        <input type="file" name="fopt1" id="fopt1" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                    </div>
                                    <div class="form-group">
                                        <label for="fopt2">Add option 2</label>
                                        <input type="file" name="fopt2" id="fopt2" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                    </div>
                                    <div class="form-group">
                                        <label for="fopt3">Add option 3</label>
                                        <input type="file" name="fopt3" id="fopt3" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                    </div>
                                    <div class="form-group">
                                        <label for="fopt4">Add option 4</label>
                                        <input type="file" name="fopt4" id="fopt4" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                    </div>
                                    <div class="form-group">
                                        <label for="fAnswer">Add Answer</label>
                                        <input type="file" name="fAnswer" id="fAnswer" class="form-control form-control-sm" style="padding-bottom: 30px;">
                                    </div>
                                    <button type="submit" name="submit2" class="btn btn-primary btn-block btn-sm">Update Exam</button>
                                </form>
                            </div>
                        </div>
                      </div> 

                      <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                           <th>No</th>
                                           <th>Questions</th>
                                           <th>opt1</th>
                                           <th>opt2</th>
                                           <th>opt3</th>
                                           <th>opt4</th>
                                           <th>Edit</th>
                                           <th>delete</th>  
                                        </tr>
                                        <?php
                                        $stmt = $link->prepare("SELECT * FROM questions WHERE category=? ORDER BY question_no ASC");
                                        $stmt->bind_param("s", $exam_category);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while($row = $res->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>".$row["question_no"]."</td>";
                                            echo "<td>".$row["question"]."</td>";

                                            $isImage = false;
                                            foreach (["opt1","opt2","opt3","opt4"] as $opt) {
                                                echo "<td>";
                                                if (strpos($row[$opt], "opt_images/") !== false) {
                                                    echo '<img src="'.$row[$opt].'" height="50" width="50">';
                                                    $isImage = true; 
                                                } else {
                                                    echo htmlspecialchars($row[$opt]);
                                                }
                                                echo "</td>";
                                            } 

                                            if ($isImage) {
                                                echo "<td><a href='edit_option_image.php?id=".$row['id']."&id1=".$id."'>Edit</a></td>";
                                            } else {
                                                echo "<td><a href='edit_option.php?id=".$row['id']."&id1=".$id."'>Edit</a></td>";
                                            }

                                            echo "<td>
                                                <a href='delete_option.php?id=".$row['id']."&id1=".$id."' 
                                                onclick=\"return confirm('Are you sure you want to delete this question?')\">
                                                Delete
                                                </a>
                                                </td>";
                                            echo "</tr>";
                                        }
                                        $stmt->close();
                                        ?>
                                    </table>
                                </div>
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

<?php 
if(isset($_POST["submit"])) {
    $loop = 0;

    // Izbroji postojeća pitanja
    $stmt = $link->prepare("SELECT id FROM questions WHERE category=? ORDER BY id ASC");
    $stmt->bind_param("s", $exam_category);
    $stmt->execute();
    $res = $stmt->get_result();
    $count = $res->num_rows;

    if($count > 0){
        while($row = $res->fetch_assoc()){
            $loop++;
            $stmtUpdate = $link->prepare("UPDATE questions SET question_no=? WHERE id=?");
            $stmtUpdate->bind_param("ii", $loop, $row['id']);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        }
    }

    $loop++;
    $stmtInsert = $link->prepare("INSERT INTO questions (question_no, question, opt1, opt2, opt3, opt4, answer, category) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("isssssss", 
        $loop, $_POST['question'], $_POST['opt1'], $_POST['opt2'], $_POST['opt3'], $_POST['opt4'], $_POST['Answer'], $exam_category);
    $stmtInsert->execute();
    $stmtInsert->close();

    header("Location: add_edit_questions.php?id=$id&success=1");
    exit;
}
?>

<?php 
if(isset($_POST["submit2"])) {
    $loop = 0;

    $stmt = $link->prepare("SELECT id FROM questions WHERE category=? ORDER BY id ASC");
    $stmt->bind_param("s", $exam_category);
    $stmt->execute();
    $res = $stmt->get_result();
    $count = $res->num_rows;

    if($count > 0){
        while($row = $res->fetch_assoc()){
            $loop++;
            $stmtUpdate = $link->prepare("UPDATE questions SET question_no=? WHERE id=?");
            $stmtUpdate->bind_param("ii", $loop, $row['id']);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        }
    }

    $loop++;
    $tm = md5(time());

    
    function uploadFile($fileKey, $tm) {
        if(!empty($_FILES[$fileKey]["name"])) {
            $fnm = $_FILES[$fileKey]["name"];
            $dst = "./opt_images/".$tm.$fnm;
            $dst_db = "opt_images/".$tm.$fnm;
            move_uploaded_file($_FILES[$fileKey]["tmp_name"], $dst);
            return $dst_db;
        }
        return "";
    }

    $dst_db1 = uploadFile("fopt1", $tm);
    $dst_db2 = uploadFile("fopt2", $tm);
    $dst_db3 = uploadFile("fopt3", $tm);
    $dst_db4 = uploadFile("fopt4", $tm);
    $dst_db5 = uploadFile("fAnswer", $tm);

    $stmtInsert = $link->prepare("INSERT INTO questions (question_no, question, opt1, opt2, opt3, opt4, answer, category) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("isssssss", 
        $loop, $_POST['fquestion'], $dst_db1, $dst_db2, $dst_db3, $dst_db4, $dst_db5, $exam_category);
    $stmtInsert->execute();
    $stmtInsert->close();

    header("Location: add_edit_questions.php?id=$id&success=1");
    exit;
}
?>
