<?php
session_start();
include "../connection.php"; 

if(!isset($_SESSION["admin_username"])){
    echo "<script>window.location = 'index.php';</script>";
    exit();
}

$message = "";

// Dodavanje novog ispita
if (isset($_POST['add_exam'])) {
    $category = trim($_POST['category']);
    $duration = trim($_POST['duration']); 

    if (!empty($category) && !empty($duration)) {
        // Provera da li exam category već postoji
        $stmt = $link->prepare("SELECT id FROM exam_category WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $message = '<div class="alert alert-danger" role="alert">❌ This exam category already exists!</div>';
        } else {
            $stmt_insert = $link->prepare("INSERT INTO exam_category (category, exam_time_in_minutes) VALUES (?, ?)");
            $stmt_insert->bind_param("si", $category, $duration);

            if ($stmt_insert->execute()) {
                $message = '<div class="alert alert-success" role="alert">✅ Exam category added successfully!</div>';
            } else {
                $message = '<div class="alert alert-danger" role="alert">❌ Error! Could not add exam category.</div>';
            }
            $stmt_insert->close();
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-warning" role="alert">⚠️ Please fill in all fields!</div>';
    }
}

// Brisanje ispita
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt_del = $link->prepare("DELETE FROM exam_category WHERE id = ?");
    $stmt_del->bind_param("i", $id);
    $stmt_del->execute();
    $stmt_del->close();
    header("Location: exam_category.php");
    exit();
}

// Dohvati sve exam category za prikaz
$stmt_list = $link->prepare("SELECT id, category, exam_time_in_minutes FROM exam_category ORDER BY id DESC");
$stmt_list->execute();
$res = $stmt_list->get_result();
?>

<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
<?php include "header.php"; ?> 

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>Add & Edit Exams</h1>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">
    <div class="animated fadeIn">
        <div class="row">
            <!-- Forma za dodavanje ispita -->
            <div class="col-md-5">
                <?php echo $message; ?>
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Add Exam</h4>
                        <form method="post" action="">
                            <div class="form-group">
                                <label for="new_exam">New exam category</label>
                                <input type="text" name="category" id="new_exam" class="form-control form-control-sm" maxlength="100" required>
                            </div>
                            <div class="form-group">
                                <label for="minutes">Exam time in minutes</label>
                                <input type="number" name="duration" id="duration" class="form-control form-control-sm" min="1" required>
                            </div>
                            <button type="submit" name="add_exam" class="btn btn-primary btn-block btn-sm">Add Exam</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista ispita -->
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header"><strong class="card-title">Exam List</strong></div>
                    <div class="card-body p-0">
                        <table class="table table-bordered table-sm mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Exam name</th>
                                    <th>Duration (min)</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $count = 0;
                                while ($row = $res->fetch_assoc()) {
                                    $count++;
                                    echo "<tr>
                                            <th>{$count}</th>
                                            <td>".htmlspecialchars($row['category'])."</td>
                                            <td>".htmlspecialchars($row['exam_time_in_minutes'])."</td>
                                            <td><a href='edit_exam.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a></td>
                                            <td>
                                                <a href='exam_category.php?delete={$row['id']}' 
                                                   class='btn btn-sm btn-danger' 
                                                   onclick=\"return confirm('Are you sure you want to delete this exam?');\">
                                                   Delete
                                                </a>
                                            </td>
                                          </tr>";
                                }
                                $stmt_list->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div> 
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script>
<script src="vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
$(document).ready(function(){
    setTimeout(function(){
        $('.alert').fadeOut('slow');
    }, 3000);
});
</script>
</body>
</html>
