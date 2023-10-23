<?php
require './parts/connect_db.php';

$PDpicture_id = isset($_GET['PDpicture_id']) ? intval($_GET['PDpicture_id']) : 0;
if(! empty($PDpicture_id)){
  $sql4 = "DELETE FROM product_picture WHERE PDpicture_id={$PDpicture_id}";
  $pdo->query($sql4);
}

$come_from = 'picture_list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
    //如果不是空的 資料
  $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");