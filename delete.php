<?php
require './parts/connect_db.php';

$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;
if(! empty($product_id)){
  $sql = "DELETE FROM product_list WHERE product_id={$product_id}";
  $pdo->query($sql);
}

$come_from = 'list.php';
if(! empty($_SERVER['HTTP_REFERER'])){
    //如果不是空的 資料
  $come_from = $_SERVER['HTTP_REFERER'];
}

header("Location: $come_from");