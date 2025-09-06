<?php
session_start();
include "../connection.php";
if(!isset($_SESSION["admin_username"])){
    ?>
    <script type="text/javascript">
        window.location = "index.php"
    </script>
    <?php
}
?>

<!doctype html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Admin Panel - Old Exam Results</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="stylesheet" href="vendors/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="vendors/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="assets/css/style.css">

<style>
    /* Center title */
    h2 {
        margin: 25px 0;
        font-weight: 700;
        color: #333;
    }

    /* Table styling */
    .results-table {
        width: 90%;
        margin: 0 auto 30px auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        border-radius: 8px;
        overflow: hidden;
    }

    .results-table thead {
        background-color: #006df0;
        color: #fff;
    }

    .results-table th, .results-table td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .results-table tbody tr:nth-child(even) {
        background-color: #f5f5f5;
    }

    .results-table tbody tr:hover {
        background-color: #d0e4ff;
        transition: 0.3s;
    }

    .no-results {
        margin: 50px 0;
        font-size: 22px;
        color: #555;
    }
</style>
</head>

<body>

<?php include "header.php"; ?>

<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <h1>All Old Exam Results</h1>
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
                        <center><h2>Old Exam Results</h2></center>

                        <?php
                        $res = mysqli_query($link,"SELECT * FROM exam_results ORDER BY id DESC");
                        $count = mysqli_num_rows($res);

                        if($count === 0){
                            echo '<center class="no-results">No Results Found</center>';
                        } else {
                            echo "<table class='table table-bordered table-hover results-table'>";
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

                            while($row = mysqli_fetch_assoc($res)){
                                echo "<tr>
                                        <td>{$row['username']}</td>
                                        <td>{$row['exam_type']}</td>
                                        <td>{$row['total_question']}</td>
                                        <td>{$row['correct_answer']}</td>
                                        <td>{$row['wrong_answer']}</td>
                                        <td>{$row['exam_time']}</td>
                                      </tr>";
                            }

                            echo "</tbody>";
                            echo "</table>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="vendors/jquery/dist/jquery.min.js"></script> <script src="vendors/popper.js/dist/umd/popper.min.js"></script> <script src="vendors/jquery-validation/dist/jquery.validate.min.js"></script> <script src="vendors/jquery-validation-unobtrusive/dist/jquery.validate.unobtrusive.min.js"></script> <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script> <script src="assets/js/main.js"></script>
</body>
</html>
