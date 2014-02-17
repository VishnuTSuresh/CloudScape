<?php

/**
 * @author Vishnu T Suresh
 */
error_reporting(E_ALL ^ E_NOTICE);

header("Content-type:text/xml");
print("<?xml version=\"1.0\"?>");
//if (isset($_GET["id"]))
//    $url_var = $_GET["id"];
//else
//    $url_var = 0;
//print("<tree id='" . $url_var . "'>");
//for ($inta = 0; $inta < 4; $inta++)
//    print("<item child='1' id='" . $url_var . "_" . $inta . "' text='Item " . $url_var . "-" . $inta . "'><userdata name='ud_block'>ud_data</userdata></item>");
//print("</tree>");
?> 
<tree id="0">
    <item child='1' id='1' text='Item 2'>
        <item child='1' id='2' text='Item 2'></item>
    </item>
    <item child='1' id='3' text='Item 3'></item>
    <item child='1' id='4' text='Item 4'></item>
    <item child='1' id='5' text='Item 5'></item>
</tree>