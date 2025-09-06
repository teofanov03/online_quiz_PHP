<?php 
session_start();
include "../connection.php";

if (!isset($_SESSION["admin_username"])) {
    ?>
    <script type="text/javascript">
        window.location = "index.php";
    </script>
    <?php
    exit;
}

if (isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = intval($_GET["id"]);

    $stmt = $link->prepare("DELETE FROM exam_category WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: exam_category.php");
exit;
