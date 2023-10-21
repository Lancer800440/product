<?php
require './parts/connect_db.php';

$PDstyle_id = isset($_GET['PDstyle_id']) ? intval($_GET['PDstyle_id']) : 0;
if(! empty($PDstyle_id)){
  $sql2 = "DELETE FROM product_style WHERE PDstyle_id={$PDstyle_id}";
  $pdo->query($sql2);
}

$come_from = 'style_list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
    //如果不是空的 資料
  $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");