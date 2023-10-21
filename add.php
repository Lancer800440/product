<?php
require './parts/connect_db.php';

$title = '新增產品';
$pageName = 'add';

$sql1 = "SELECT * FROM product_category";
$sql2 = "SELECT * FROM product_style";
$sql3 = "SELECT * FROM product_color";

$rows = $pdo->query($sql1)->fetchAll();
$rows2 = $pdo->query($sql2)->fetchAll();
$rows3 = $pdo->query($sql3)->fetchAll();
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>


<!-- 這是給  出現錯誤的時候才用的 -->
<style>
  form .form-text {
    color: red;
  }
</style>



<h2><?= $_SESSION['admin']['nickname'] ?> 您好</h2>

<div class="container">
  <div class="row">
    <div class="col-6">
      <div class="card">

        <div class="card-body">
          <h5 class="card-title">新增資料</h5>

          <form name="form1" onsubmit="sendData(event)">
            <div class="mb-3">
              <label for="product_name" class="form-label">商品名稱</label>
              <input type="text" class="form-control" id="product_name" name="product_name">
              <div class="form-text"></div>
            </div>

            <div class="card-title">商品類別</div>
            <div class="input-group mb-3">
              <span class="input-group-text">主分類</span>
              <select class="form-select" name="PDcategory_id" id="cate1" onchange="generateCate2List()">
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
              <select class="form-select" name="PDcategory_id" id="cate2"></select>
            </div>

            <div class="card-title">商品造型</div>
            <div class="input-group mb-3">
              <select class="form-select" name="PDstyle_id" id="style1" onchange="generateStyleList()">
                <?php foreach ($rows2 as $r) : ?>
                  <option value="<?= $r['PDstyle_id'] ?>"><?= $r['PDstyle_name'] ?></option>
                <?php
                endforeach ?>
              </select>
            </div>

            <div class="card-title">商品顏色</div>
            <div class="input-group mb-3">

              <select class="form-select" name="PDcolor_id" id="color1" onchange="generateColorList()">
                <?php foreach ($rows3 as $r) : ?>
                  <option value="<?= $r['PDcolor_id'] ?>"><?= $r['PDcolor_name'] ?></option>
                <?php
                endforeach ?>
              </select>
            </div>
            <div class="mb-3">
              <label for="product_price" class="form-label">商品單價</label>
              <input type="text" class="form-control" id="product_price" name="product_price">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="product_picture" class="form-label">商品照片</label>
              <input type="text" class="form-control" id="product_picture" name="product_picture">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="product_inventory_quantity" class="form-label">數量</label>
              <input type="text" class="form-control" id="product_inventory_quantity" name="product_inventory_quantity">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="product_description" class="form-label">商品描述</label>
              <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="3"></textarea>
              <div class="form-text"></div>
            </div>

            <button type="submit" class="btn btn-primary">新增產品</button>
          </form>

        </div>
      </div>
    </div>
  </div>


</div>

<?php include './parts/scripts.php' ?>
<script>
  const product_name_in = document.form1.product_name;
  // const email_in = document.form1.email;
  // const mobile_in = document.form1.mobile;
  // const fields = [name_in, email_in, mobile_in];

  // email的格式
  // function validateEmail(email) {
  //   const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  //   return re.test(email);
  // }

  //手機的格式
  // function validateMobile(mobile) {
  //   const re = /^09\d{2}-?\d{3}-?\d{3}$/;
  //   return re.test(mobile);
  // }

  function sendData(e) {
    e.preventDefault(); // 不要讓表單以傳統的方式送出

    // 外觀要回復原來的狀態
    product_name_in.style.border = '1px solid #CCCCCC';
    product_name_in.nextElementSibling.innerHTML = '';
    // fields.forEach(field => {
    //   field.style.border = '1px solid #CCCCCC';
    //   field.nextElementSibling.innerHTML = '';
    // })    

    // TODO: 資料在送出之前, 要檢查格式
    let isPass = true; // 有沒有通過檢查

    //判斷name的格式 以及給出提醒


    /*
    if (name_in.value.length < 2) {
      isPass = false;
      name_in.style.border = '2px solid red';
      name_in.nextElementSibling.innerHTML = '請填寫正確的姓名';
      //属性返回指定元素之后的下一个兄弟元素（相同节点树层中的下一个元素节点）
    }  

    //判斷email 如果不是對的內容
    if (!validateEmail(email_in.value)) {
      isPass = false;
      email_in.style.border = '2px solid red';
      email_in.nextElementSibling.innerHTML = '請填寫正確的 Email';
    }
    */

    // 非必填  如果有寫內容且內容錯誤 才要跳出錯誤訊息
    // if (mobile_in.value && !validateMobile(mobile_in.value)) {
    //   isPass = false;
    //   mobile_in.style.border = '2px solid red';
    //   mobile_in.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
    // }

    if (!isPass) {
      return; // 沒有通過就不要發送資料
    }

    // 建立只有資料的表單
    const fd = new FormData(document.form1);

    fetch('add-api.php', {
        method: 'POST',
        body: fd, // 送出的格式會自動是 multipart/form-data
      }).then(r => r.json())
      .then(data => {
        console.log({
          data
        });
        if (data.success) {
          alert('資料新增成功');
          location.href = "./list.php"
        } else {
          //alert('發生問題');
          for (let n in data.errors) {
            console.log(`n: ${n}`);
            if (document.form1[n]) {
              const input = document.form1[n];
              input.style.border = '2px solid red';
              input.nextElementSibling.innerHTML = data.errors[n];
            }
          }
        }
      })
      .catch(ex => console.log(ex))
  }

  // 新增商品類別選單
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