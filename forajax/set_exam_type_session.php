<?php
session_start();
include "../connection.php";

$exam_category = $_GET["exam_category"];
$_SESSION["exam_category"] = $exam_category;

$res = mysqli_query($link,"SELECT * FROM exam_category WHERE category = '$exam_category'");
if($row = mysqli_fetch_assoc($res)){
    $_SESSION["exam_time"] = $row["exam_time_in_minutes"];
}

$_SESSION["exam_start"] = "yes";
$_SESSION["end_time"] = date("Y-m-d H:i:s", strtotime("+{$_SESSION['exam_time']} minutes"));

echo "OK";
?>
