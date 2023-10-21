<?php
require './parts/connect_db.php';

# 告訴用戶端, 資料格式為 JSON
header('Content-Type: application/json');
#echo json_encode($_POST);
#exit; // 結束程式


$output = [
    'postData' => $_POST,
    'success' => false,
    // 'error' => '',
    'errors' => [],
];


// 取得資料的 PK
$product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;

if (empty($product_id)) {
    $output['errors']['product_id'] = "沒有 PK";
    echo json_encode($output);
    exit; // 結束程式
}

//後端檢查 從add表單獲取的值
$product_name = $_POST['product_name']?? '';
$PDcategory_id = $_POST['PDcategory_id']?? '';
$PDstyle_id = $_POST['PDstyle_id'] ?? '';
$PDcolor_id = $_POST['PDcolor_id'] ?? '';
$product_price = $_POST['product_price'] ?? '';
$product_picture = $_POST['product_picture'] ?? '';
$product_inventory_quantity = $_POST['product_inventory_quantity'] ?? '';
$product_description = $_POST['product_description'] ?? '';



// TODO: 資料在寫入之前, 要檢查格式

// trim(): 去除頭尾的空白
// strlen(): 查看字串的長度
// mb_strlen(): 查看中文字串的長度

$isPass = true;
// if (empty($name)) {
//     $isPass = false;
//     $output['errors']['name'] = '請填寫正確的姓名';
// }

// if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     $isPass = false;
//     $output['errors']['email'] = 'email 格式錯誤';
// }

# 如果沒有通過檢查
if (!$isPass) {
    echo json_encode($output);
    exit;
}

$sql = "UPDATE `product_list` SET 
  `product_name`=?,
  `PDcategory_id`=?,
  `PDstyle_id`=?,
  `PDcolor_id`=?,
  `product_price`=?,
  `product_picture`=?,
  `product_inventory_quantity`=?,
  `product_description`=?
WHERE `product_id`=? ";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    $product_name,
    $PDcategory_id,
    $PDstyle_id,
    $PDcolor_id,
    $product_price,
    $product_picture,
    $product_inventory_quantity,
    $product_description,
    $product_id
]);

$output['rowCount'] = $stmt->rowCount();
$output['success'] = boolval($stmt->rowCount());
echo json_encode($output);
