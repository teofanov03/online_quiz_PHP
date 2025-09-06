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

$id = isset($_GET["id"]) ? intval($_GET["id"]) : 0;
$id1 = isset($_GET["id1"]) ? intval($_GET["id1"]) : 0;

if ($id > 0) {
    $stmt = $link->prepare("DELETE FROM questions WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
<script type="text/javascript">
    window.location = "add_edit_questions.php?id=<?php echo $id1; ?>";
</script>
