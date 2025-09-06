<?php
session_start();
include "../connection.php"; 

if (!isset($_SESSION["admin_username"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
    exit();
}

$message = "";

// Validacija ID-a
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: exam_category.php");
    exit();
}

$id = intval($_GET['id']);

// Uzimanje trenutnog egzama
$stmt = $link->prepare("SELECT * FROM exam_category WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $stmt->close();
    header("Location: exam_category.php");
    exit();
}

$row = $result->fetch_assoc();
$stmt->close();

// UPDATE egzama
if (isset($_POST['update_exam'])) {
    $category = trim($_POST['category']);
    $duration = intval($_POST['duration']); // cast na int jer mora biti broj

    if (!empty($category) && $duration > 0) {
        $stmt = $link->prepare("UPDATE exam_category SET category = ?, exam_time_in_minutes = ? WHERE id = ?");
        $stmt->bind_param("sii", $category, $duration, $id);

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success" role="alert">✅ Exam updated successfully!</div>';
            // Osveži podatke
            $row['category'] = $category;
            $row['exam_time_in_minutes'] = $duration;
        } else {
            $message = '<div class="alert alert-danger" role="alert">❌ Error! Could not update exam.</div>';
        }
        $stmt->close();
    } else {
        $message = '<div class="alert alert-warning" role="alert">⚠️ Please fill in all fields correctly!</div>';
    }
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>Edit Exam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    
    <?php include "header.php"; ?> 

    <div class="breadcrumbs">
        <div class="col-sm-4">
            <div class="page-header float-left">
                <div class="page-title">
                    <h1>Edit Exam</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <div class="animated fadeIn">
            <div class="row justify-content-center">
                <div class="col-md-4">
                    <?php echo $message; ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title text-center mb-4">Edit Exam</h4>
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="category">Exam category</label>
                                    <input type="text" name="category" id="category" class="form-control form-control-sm"
                                           value="<?php echo htmlspecialchars($row['category']); ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Exam time in minutes</label>
                                    <input type="number" name="duration" id="duration" class="form-control form-control-sm"
                                           value="<?php echo htmlspecialchars($row['exam_time_in_minutes']); ?>" min="1" required>
                                </div>
                                <button type="submit" name="update_exam" class="btn btn-primary btn-block btn-sm">Update Exam</button>
                                <a href="exam_category.php" class="btn btn-secondary btn-block btn-sm">Back</a>
                            </form>
                        </div>
                    </div>
                </div> 
            </div> 
        </div>
    </div>

    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
