<?php

require './parts/connect_db.php';
$title = '商品類別';
$pageName = 'product_category';


$sql = "SELECT * FROM product_category";

$rows = $pdo->query($sql)->fetchAll();

#echo json_encode($rows, JSON_UNESCAPED_UNICODE);
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>

<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">表單</h5>

          <form name="form1" onsubmit="return false">
            <div class="input-group mb-3">
              <span class="input-group-text">主分類</span>

              <select class="form-select" name="cate1" id="cate1" onchange="generateCate2List()">
                <?php foreach ($rows as $r) :
                  if ($r['parent_PDcategory_id'] == '0') : ?>
                    <option value="<?= $r['PDcategory_id'] ?>"><?= $r['PDcategory_name'] ?></option>
                <?php
                  endif;
                endforeach ?>
              </select>
            </div>
            <div class="input-group mb-3">
              <span class="input-group-text">次分類</span>
              <select class="form-select" name="cate2" id="cate2"></select>
            </div>


            <button type="submit" class="btn btn-primary">Submit</button>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>



<?php include './parts/scripts.php' ?>
<script>
  // 假設我希望第一層初始值為第二個
  const initVals = {
    cate1: 1,
    cate2: 11
  };




  const cates = <?= json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;

  const cate1 = document.querySelector('#cate1')
  const cate2 = document.querySelector('#cate2')



  function generateCate2List() { //呼叫generateCate2List()
    const cate1Val = cate1.value; // 主分類的值

    let str = "";
    //b;
    for (let item of cates) {
      if (+item.parent_PDcategory_id === +cate1Val) { //+ cate1轉成字串
        str += `<option value="${item.PDcategory_id}">${item.PDcategory_name}</option>`;
        //a;
      }
    }

    cate2.innerHTML = str;

  }
  cate1.value = initVals.cate1; // 設定第一層的初始值
  generateCate2List(); // 生第二層
  cate2.value = initVals.cate2; // 設定第二層的初始值
</script>
<?php include './parts/html-foot.php' ?>