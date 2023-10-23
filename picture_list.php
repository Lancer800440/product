<?php
require './parts/connect_db.php';
$pageName = 'picture_list';
$title = '照片列表';

$perPage = 20; # 一頁最多有幾筆

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
    header('Location: ?page=1'); # 頁面轉向
    exit; # 直接結束這支 php
}


$t_sql = "SELECT COUNT(1) FROM product_picture";

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

    // select * from ((product_picture join product_picture on product_picture.PDpicture_id = product_picture.PDpicture_id)
    // join product_picture on product_picture.PDpicture_id = product_picture.PDpicture_id)
    // join product_category on product_picture.PDcategory_id = Product_category.PDcategory_id;


    //   $sql = sprintf(
    //     "SELECT * FROM product_picture ORDER BY PDpicture_id DESC LIMIT %s, %s",
    //     ($page - 1) * $perPage,
    //     $perPage

    // );
    $sql4 = sprintf(
        "SELECT * FROM product_picture ORDER BY PDpicture_id 
        DESC LIMIT %s, %s",
        ($page - 1) * $perPage,
        $perPage

    );
    $rows = $pdo->query($sql4)->fetchAll();
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
                    <?php for ($i = $page - 5; $i <= $page + 5; $i++) :

                        if ($i >= 1 and $i <= $totalPages) : ?>

                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <!-- 加上active  點了會反白 -->

                                <a class="page-link" href=" ?page= <?= $i ?>">
                                    <?= $i ?>
                                </a>
                            </li>
                        <?php endif ?>
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
                        <th><i class="fa-solid fa-trash-can"></i></th>
                        <!-- <th scope="col">編號</th> -->
                        <th scope="col">照片編號</th>
                        <th scope="col">照片檔名</th>
                        <th><i class="fa-solid fa-file-pen"></i></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $r) : ?>
                        <tr>
                            <th><a href="javascript: deleteItem(<?= $r['PDpicture_id'] ?>)">
                                    <i class="fa-solid fa-trash-can"></i>
                                </a></th>
                            <td><?= $r['PDpicture_id'] ?></td>
                            <!-- <td><?= $r['PDpicture_name'] ?></td> -->

                            <td style="width: 300px">  
                                <img src="/my-proj/add+cate-HTML-1/uploads/<?= $r['PDpicture_name']  ?>" id="PDpicture_name_img" width="100%" />
                            </td>

                            <th><a href="picture_edit.php?PDpicture_id=<?= $r['PDpicture_id'] ?>">
                                    <i class="fa-solid fa-file-pen"></i>
                                </a></th>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <button class="btn btn-danger" type="submit"><a class="nav-link <?= $pageName == 'picture' ? 'active' : '' ?>" href="picture_add.php">新增產品照片</a></button>
        </div>
    </div>
</div>



<?php include './parts/scripts.php' ?>
<script>
    function deleteItem(PDpicture_id) {
        if (confirm(`確定要刪除編號為 ${PDpicture_id} 的資料嗎?`)) {
            location.href = 'picture_delete.php?PDpicture_id=' + PDpicture_id;
        }
    }
</script>
<?php include './parts/html-foot.php' ?>