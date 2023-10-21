<?php
require './parts/connect_db.php';

# 检查是否已登录
// if (isset($_SESSION['admin'])) {
//   $loggedInUser = $_SESSION['admin'];

//   # 获取用户的 ID、昵称等信息
//   $Member_ID = $loggedInUser['member_id'];
//   $nickname = $loggedInUser['nickname'];
// }


$output = [
  'postData' => $_POST,
  'success' => false,
  // 'error' => '',
  'errors' => [],
];


# 告訴用戶端, 資料格式為 JSON
header('Content-Type: application/json');

//判斷是否缺少欄位值  有缺少就顯示缺少  並echo json格式的output欄位

/*
if(empty($_POST['name']) or empty($_POST['email'])){
    $output['errors']['form'] = '缺少欄位資料';
    echo json_encode($output);
    exit;
}
*/



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
//   $isPass = false;
//   $output['errors']['name'] = '請填寫正確的姓名';
// }

// if(! filter_var($email, FILTER_VALIDATE_EMAIL)){
//   $isPass = false;
//   $output['errors']['email'] = 'email 格式錯誤';
// }


# 如果沒有通過檢查
if(! $isPass){
  echo json_encode($output);
  exit;
}


$sql = "INSERT INTO `product_list`(
  `product_name`, `PDcategory_id`, `PDstyle_id`, `PDcolor_id`, `product_price`, 
  `product_picture`,`product_inventory_quantity`,`product_description`
  ) VALUES(
    ?, ?, ?, ?, ?, ?, ?, ?
  )";

$stmt = $pdo->prepare($sql);

// $stmt->execute([
//   $_POST['name'],
//   $_POST['email'],
//   $_POST['mobile'],
//   $_POST['birthday'],
//   $_POST['address'],
// ]);

// 下面這些值要灌入我的系統
$stmt->execute([
  $product_name,
  $PDcategory_id,
  $PDstyle_id,
  $PDcolor_id,
  $product_price,
  $product_picture,
  $product_inventory_quantity,
  $product_description
]);


/*
#錯誤作法：

會有 SQL injection

   $sql = sprintf("INSERT INTO `address_book`(
     `name`, `email`, `mobile`, `birthday`, `address`, `created_at`
     ) VALUES (
       '%s', '%s', '%s', '%s', '%s', NOW()

//值如果包含單引號就會出錯

     )", 
       $_POST['name'],
       $_POST['email'],
       $_POST['mobile'],
       $_POST['birthday'],
       $_POST['address']
   );

   $stmt = $pdo->query($sql);
*/




/*
#一開始的傳統做法

echo json_encode([
  'postData' => $_POST,
  'rowCount' => $stmt->rowCount(),
]);
*/

$output['lastInsertId'] = $pdo->lastInsertId(); # 取得最新資料的 primary key
$output['success'] = boolval($stmt->rowCount());
echo json_encode($output);


