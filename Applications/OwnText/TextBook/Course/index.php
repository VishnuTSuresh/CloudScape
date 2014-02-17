<?php
/**
 * @author Vishnu T Suresh
 */
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("OwnText");
$course_id = isset($_GET["id"]) ? $_GET["id"] : null;
if ($course_id) {
    $course = Course::withId($course_id);
} else {
    $course_id = null;
}
?>
<link rel="stylesheet" type="text/css" href="\Resources\script\jstree\dist\themes\default\style.min.css"></link>
<script src="\Resources\script\jstree\dist\jstree.min.js" type="text/javascript"></script>
<h1>
    <a href="/OwnText">OwnText</a> 
    &rsaquo; 
    <a href="/OwnText/TextBook">TextBook</a>

    <?php
    if ($course) {
        echo "&rsaquo; " . $course->getName();
    }
    ?>
</h1>
<h2>Table of Contents</h2>
<div id="tree">
    <ul>
        <li>Root node 1
            <ul>
                <li data-jstree='{ "selected" : true }'><a href="#"><em>initially</em> <strong>selected</strong></a></li>
                <li data-jstree='{ "icon" : "http://jstree.com/tree-icon.png" }'>custom icon URL</li>
                <li data-jstree='{ "opened" : true }'>initially open
                    <ul>
                        <li>Another node</li>
                    </ul>
                </li>
                <li data-jstree='{ "icon" : "glyphicon glyphicon-leaf" }'>Custom icon class (bootstrap)</li>
            </ul>
        </li>
        <li><a href="http://www.jstree.com">Root node 2</a></li>
    </ul>
</div>
<br>                

<script>
    $(function() {
        x = $('#tree').jstree({
            "core": {
                // so that create works
                "check_callback": true
            },
            "plugins": ["dnd"]
        });
    });
</script>
<?php
$options = null;
if ($course) {
    $options = [
        "appTools" => [
            ["name" => "Edit", "credentials" => ["LOGIN"], "url" => "Edit.php", "query" => ["course_id" => $course_id]],
        ]
    ];
}
ThisPage::renderBottom($options);
?>