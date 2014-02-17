<?php
/**
 *
 * @author Vishnu T Suresh
 *
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("OwnText");
$pid = isset($_GET["pid"]) ? intval($_GET["pid"]) : null;
$sem = isset($_GET["sem"]) ? intval($_GET["sem"]) : null;

$programme = Programme::get($pid);
if (!$programme) {
    $pid = null;
}
if ($programme && $sem && !(($sem <= $programme->getNoOfSemesters()) && ($sem > 0))) {
    $sem = null;
}
?>
<style>
    .owntexteven{
        background-color: #eee;
    }
    .owntextodd{

    }
    .owntexteven,.owntextodd{
        padding: 10px 5px;
    }
</style>
<h1>
    <a href="/OwnText">OwnText</a> &rsaquo; <a href="/OwnText/TextBook">TextBook</a>
    <?php
    if ($pid) {
        ?>
        &rsaquo; <a href="?pid=<?php echo $pid ?>"><?php echo $programme->getName(); ?></a>
        <?php
        if ($sem) {
            ?>
            &rsaquo; <a href="?pid=<?php echo $pid ?>&sem=<?php echo $sem ?>">Semester <?php echo $sem; ?></a>
            <?php
        }
    }
    ?>
</h1>
<?php
if (!$pid) {
    $programmes = Programme::getAll();
    foreach ($programmes as $index => $programme) {
        $evenodd = $index % 2 == 0 ? "owntexteven" : "owntextodd";
        ?>
        <div class="<?php echo $evenodd ?>" ><a href="?pid=<?php echo $programme->getId() ?>"><?php echo $programme->getName(); ?></a></div>
        <?php
    }
} else {
    if (!$sem) {
        $no_of_semesters = $programme->getNoOfSemesters();
        for ($semester = 1; $semester <= $no_of_semesters; $semester++) {
            $season = $semester % 2 == 0 ? "Spring" : "Autumn";
            $year = intval(($semester + 1) / 2);
            $evenodd = $season=="Autumn" ? "owntexteven" : "owntextodd";
            ?>
            <div class="<?php echo $evenodd ?>">
                <a href="?pid=<?php echo $pid ?>&sem=<?php echo $semester ?>"><?php echo "Year $year, $season Semester"; ?></a>
            </div>
            <?php
        }
    } else {
        $courses = $programme->getCourses($sem);
        foreach ($courses as $index=>$course) {
            $evenodd = $index % 2 == 0 ? "owntexteven" : "owntextodd";
            ?>
            <div class="<?php echo $evenodd ?>">
                <a href="Course?id=<?php echo $course->getId() ?>"><?php echo $course->getName(); ?></a>
            </div>
            <?php
        }
    }
}
ThisPage::renderBottom();
?>