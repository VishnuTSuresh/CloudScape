<?php
/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("OwnText");
$course_id = isset($_GET["course_id"]) ? $_GET["course_id"] : null;
$course = Course::withId($course_id);
if (!$course) {
    $course_id = null;
}
?>
<h1><a href="/OwnText">OwnText</a> 
    &rsaquo; 
    <a href="/OwnText/TextBook">TextBook</a>

    <?php
    if ($course) {
        echo "&rsaquo; <a href='./?id=".$course->getId()."'>" . $course->getName()."</a>";
    }
    ?> &rsaquo; Edit</h1>
<?php
if ($course) {
    ?>

    <?php
} else {
    ?>
<div class="error">Course does not exist</div>
    <?php
}
ThisPage::renderBottom();
?>
