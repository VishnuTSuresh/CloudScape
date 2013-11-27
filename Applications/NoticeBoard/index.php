<?php
require_once "$_SERVER[DOCUMENT_ROOT]/../PHP_Code/__autoload.php";
ThisPage::renderTop("Notice Board");
?>
<link rel="stylesheet" href="style.css" type="text/css"/>
<link rel="stylesheet" href="/Resources/script/w2ui/w2ui-1.3.min.css" type="text/css"/>
<script type="text/javascript" src="/Resources/script/w2ui/w2ui-1.3.min.js"></script>
<script type="text/javascript" src="script.js"></script>
<h1>Notice Board</h1>
<div id="notice_board" style="height:400px;">
</div>
<?php ThisPage::renderBottom();?>
