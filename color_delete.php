<?php
require './parts/connect_db.php';

$PDcolor_id = isset($_GET['PDcolor_id']) ? intval($_GET['PDcolor_id']) : 0;
if(! empty($PDcolor_id)){
  $sql2 = "DELETE FROM product_color WHERE PDcolor_id={$PDcolor_id}";
  $pdo->query($sql2);
}

$come_from = 'color_list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
    //如果不是空的 資料
  $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");