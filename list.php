<?php
require './parts/connect_db.php';
$pageName = 'list';
$title = '列表';

$perPage = 20; # 一頁最多有幾筆

$page=isset($_GET['page'])?intval($_GET['page']):1;
if($page<1){
    header('Location: ?page=1'); # 頁面轉向
    exit; # 直接結束這支 php
}


$t_sql = "SELECT COUNT(1) FROM product_list";

# 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];



# 預設值 預設=0
$totalPages = 0;
$rows = [];


// 有資料時 => 總筆數totalRows不是0
if ($totalRows > 0) {
    # 總頁數
    $totalPages = ceil($totalRows / $perPage);
        if ($page > $totalPages) {
          header('Location: ?page=' . $totalPages); # 頁面轉向最後一頁
          exit; # 直接結束這支 php
        }
    
    // select * from ((product_list join product_style on product_list.PDstyle_id = product_style.PDstyle_id)
    // join product_color on product_list.PDcolor_id = product_color.PDcolor_id)
    // join product_category on product_list.PDcategory_id = Product_category.PDcategory_id;
    
    
  //   $sql = sprintf(
  //     "SELECT * FROM product_list ORDER BY product_id DESC LIMIT %s, %s",
  //     ($page - 1) * $perPage,
  //     $perPage

  // );
    $sql = sprintf(
        "SELECT * FROM ((product_list join product_style on product_list.PDstyle_id = product_style.PDstyle_id)
        join product_color on product_list.PDcolor_id = product_color.PDcolor_id)
        join product_category on product_list.PDcategory_id = Product_category.PDcategory_id ORDER BY product_id 
        DESC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage

    );
    $rows = $pdo->query($sql)->fetchAll();
}


?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>

<div class="container">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <!-- 左按鈕 -->
            <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <!-- if page=第一頁 則功能消失 -->
                <a class="page-link" href="?page=1">
                    <i class="fa-solid fa-angles-left">
                    </i>
                </a>
            </li>


            <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->


            <!--  for($i=1; $i<= $totalPages; $i++):   -->
            <?php for($i = $page-5; $i <= $page+5; $i++):  

            if($i>=1 and $i<=$totalPages):?>

                <li class="page-item <?= $i==$page ? 'active' : '' ?>">
                <!-- 加上active  點了會反白 -->

                    <a class="page-link" href=" ?page= <?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endif?>
            <?php endfor ?>
          
          <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->

          <!-- 右按鈕 -->
            <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>"> 
            <!-- if page=最後一頁 則功能消失 -->
                <a class="page-link" href="?page=<?= $totalPages ?>">
                    <i class="fa-solid fa-angles-right">
                    </i>
                </a>
            </li>
        </ul>
      </nav>
    </div>
  </div>

  <!-- 總筆數/總頁數 -->
  <div><?= "$totalRows / $totalPages" ?></div>

  <h2><?= $_SESSION['admin']['nickname'] ?> 您好</h2>
  
  <div class="row">
    <div class="col">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th ><i class="fa-solid fa-trash-can"></i></th>
            <!-- <th scope="col">編號</th> -->
            <th scope="col">商品編號</th>
            <th scope="col">商品名稱</th>
            <th scope="col">商品類別</th>
            <th scope="col">商品造型</th>
            <th scope="col">商品顏色</th>
            <th scope="col">商品單價</th>
            <th scope="col">商品照片</th>
            <th scope="col">數量</th>
            <th scope="col">商品描述</th>
            <th ><i class="fa-solid fa-file-pen"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($rows as $r): ?>
          <tr>
            <th ><a href="javascript: deleteItem(<?= $r['product_id'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a></th>
            <!-- <td><?= $r['product_id'] ?></td> -->
            <td><?= $r['product_id'] ?></td>
            <td><?= $r['product_name'] ?></td>
            <td><?= $r['PDcategory_name'] ?></td>
            <td><?= $r['PDstyle_name'] ?></td>
            <td><?= $r['PDcolor_name'] ?></td>
            <td><?= $r['product_price'] ?></td>
            <td><?= $r['product_picture'] ?></td>
            <td><?= $r['product_inventory_quantity'] ?></td>
            <td><?= htmlentities($r['product_description']) ?>
            <!-- <?= strip_tags($r['product_description']) ?> -->
            <th ><a href="edit.php?product_id=<?= $r['product_id'] ?>">
                  <i class="fa-solid fa-file-pen"></i>
                </a></th>
          </tr>
          <?php endforeach ?>
        </tbody>
      </table>
    </div>
  </div>


</div>



<?php include './parts/scripts.php' ?>
<script>
  function deleteItem(product_id) {
    if (confirm(`確定要刪除編號為 ${product_id} 的資料嗎?`)) {
      location.href = 'delete.php?product_id=' + product_id;
    }
  }
</script>
<?php include './parts/html-foot.php' ?>