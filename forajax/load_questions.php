<?php
session_start();
include "../connection.php";

$question = "";
$opt1 = $opt2 = $opt3 = $opt4 = "";
$ans = "";
$queno = (int)$_GET["questionno"]; 


if(isset($_SESSION["answer"][$queno])){
    $ans = $_SESSION["answer"][$queno];
}

$offset = $queno - 1;
$res = mysqli_query($link,"SELECT * FROM questions WHERE category = '$_SESSION[exam_category]' ORDER BY question_no ASC LIMIT 1 OFFSET $offset");
$count = mysqli_num_rows($res);

if($count == 0){
    echo "over";
} else {
    $row = mysqli_fetch_assoc($res);

    $question_no = $queno; 
    $question = $row["question"];
    $opt1 = $row["opt1"];
    $opt2 = $row["opt2"];
    $opt3 = $row["opt3"];
    $opt4 = $row["opt4"];

    
    function render_option($opt, $ans, $question_no){
        if(empty($opt)) return;

        echo '<tr>';
        echo '<td>';
        echo '<input type="radio" name="r1" value="'.htmlspecialchars($opt).'" onclick="radioclick(this.value, '.$question_no.')"';
        if($ans == $opt) echo ' checked';
        echo '>';
        echo '</td>';

        echo '<td style="padding-left:10px;">';
        if(strpos($opt, 'images/') !== false){
            echo '<img src="admin/'.htmlspecialchars($opt).'" style="max-height:150px; max-width:150px; object-fit:contain;" alt="">';
        } else {
            echo htmlspecialchars($opt);
        }
        echo '</td>';
        echo '</tr>';
    }
    ?>
    <table>
        <tr>
            <td style="font-weight: bold; font-size:18px; padding-left:5px" colspan="2">
                <?php echo "(".$question_no.") ".$question; ?>
            </td>
        </tr>
    </table>

    <table style="margin-left: 20px;">
        <?php
            render_option($opt1, $ans, $question_no);
            render_option($opt2, $ans, $question_no);
            render_option($opt3, $ans, $question_no);
            render_option($opt4, $ans, $question_no);
        ?>
    </table>
<?php
}
?>
