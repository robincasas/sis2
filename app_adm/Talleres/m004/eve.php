<?php

require "../../../inc/fwo_main.php";
require "biz.php";
$biz = new biz($_REQUEST["header"]);
switch ($_REQUEST["evento"]) {
  case "inicio" :
    $biz->inicio();
    break;

}
?>
