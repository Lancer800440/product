<?php

require './parts/connect_db.php';

// 取得資料的 PK
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if (empty($product_id)) {
    header('Location: list.php');
    exit; // 結束程式
}

$sql = "SELECT * FROM product_list WHERE product_id={$product_id}";
$row = $pdo->query($sql)->fetch();
if (empty($row)) {
    header('Location: list.php');
    exit; // 結束程式
}

$sql1 = "SELECT * FROM product_category";
$rows = $pdo->query($sql1)->fetchAll();

$sql2 = "SELECT * FROM product_style";
$rows2 = $pdo->query($sql2)->fetchAll();

$sql3 = "SELECT * FROM product_color";
$rows3 = $pdo->query($sql3)->fetchAll();

#echo json_encode($row, JSON_UNESCAPED_UNICODE);
$title = '編輯資料';

$product_description = isset($_POST['product_description']) ? $_POST['product_description'] : $row['product_description'];
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<style>
    form .form-text {
        color: red;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">

                <div class="card-body">
                    <h5 class="card-title">編輯資料</h5>

                    <form name="form1" onsubmit="sendData(event)">
                        <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                        <div class="mb-3">
                            <label for="product_name" class="form-label">商品名稱</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="<?= htmlentities($row['product_name']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="card-title">商品類別</div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">主分類</span>
                            <select class="form-select" name="PDcategory_id" id="cate1" onchange="generateCate2List()">
                                <?php foreach ($rows as $r) :
                                    if ($r['parent_PDcategory_id'] == $row['parent_PDcategory_id']) : ?>
                                        <option value="<?= $r['PDcategory_id'] ?>" <?= $r['PDcategory_id'] == $row['PDcategory_id'] ? 'selected' : "" ?>><?= $r['PDcategory_name'] ?></option>
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
                                    <option value="<?= $r['PDstyle_id'] ?>" <?= $r['PDstyle_id'] == $row['PDstyle_id'] ? 'selected' : "" ?>><?= $r['PDstyle_name'] ?></option>
                                <?php
                                endforeach ?>
                            </select>
                        </div>

                        <div class="card-title">商品顏色</div>
                        <div class="input-group mb-3">
                            <select class="form-select" name="PDcolor_id" id="color1" onchange="generateColorList()">
                                <?php foreach ($rows3 as $r) : ?>
                                    <option value="<?= $r['PDcolor_id'] ?>" <?= $r['PDcolor_id'] == $row['PDcolor_id'] ? 'selected' : "" ?>><?= $r['PDcolor_name'] ?></option>
                                <?php
                                endforeach ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="product_price" class="form-label">商品單價</label>
                            <input type="text" class="form-control" id="product_price" name="product_price" value="<?= htmlentities($row['product_price']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_picture" class="form-label">商品照片</label>
                            <input type="text" class="form-control" id="product_picture" name="product_picture" value="<?= htmlentities($row['product_picture']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_inventory_quantity" class="form-label">數量</label>
                            <input type="text" class="form-control" id="product_inventory_quantity" name="product_inventory_quantity" value="<?= htmlentities($row['product_inventory_quantity']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <div class="mb-3">
                            <label for="product_description" class="form-label">商品描述</label>
                            <textarea class="form-control" name="product_description" id="product_description" cols="30" rows="3"><?= htmlentities($product_description) ?></textarea>
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">確認</button>
                    </form>

                </div>
            </div>
        </div>
    </div>


</div>

<?php include './parts/scripts.php' ?>
<script>
    // const product_name_in = document.form1.product_name;
    // const email_in = document.form1.email;
    // const mobile_in = document.form1.mobile;
    // const fields = [name_in, email_in, mobile_in];

    // function validateEmail(email) {
    //     const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    //     return re.test(email);
    // }

    // function validateMobile(mobile) {
    //     const re = /^09\d{2}-?\d{3}-?\d{3}$/;
    //     return re.test(mobile);
    // }


    function sendData(e) {
        e.preventDefault(); // 不要讓表單以傳統的方式送出

        // 外觀要回復原來的狀態
        // fields.forEach(field => {
        //     field.style.border = '1px solid #CCCCCC';
        //     field.nextElementSibling.innerHTML = '';
        // })

        // TODO: 資料在送出之前, 要檢查格式
        let isPass = true; // 有沒有通過檢查

        // if (name_in.value.length < 2) {
        //     isPass = false;
        //     name_in.style.border = '2px solid red';
        //     name_in.nextElementSibling.innerHTML = '請填寫正確的姓名';
        // }

        // if (!validateEmail(email_in.value)) {
        //     isPass = false;
        //     email_in.style.border = '2px solid red';
        //     email_in.nextElementSibling.innerHTML = '請填寫正確的 Email';
        // }

        // // 非必填
        // if (mobile_in.value && !validateMobile(mobile_in.value)) {
        //     isPass = false;
        //     mobile_in.style.border = '2px solid red';
        //     mobile_in.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
        // }


        if (!isPass) {
            return; // 沒有通過就不要發送資料
        }
        // 建立只有資料的表單
        const fd = new FormData(document.form1);

        fetch('edit-api.php', {
                method: 'POST',
                body: fd, // 送出的格式會自動是 multipart/form-data
            }).then(r => r.json())
            .then(data => {
                console.log({
                    data
                });
                if (data.success) {
                    alert('資料編輯成功');
                    location.href = "./list.php"
                } else {
                    alert('資料沒有修改');
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
    // const initVals = {
    //     // cate1: 1,
    //     // cate2: 11
    // };

    const cates = <?= json_encode($rows, JSON_UNESCAPED_UNICODE) ?>;

    const cate1 = document.querySelector('#cate1')
    const cate2 = document.querySelector('#cate2')

    function generateCate2List() { //呼叫generateCate2List()
        const cate1Val1 = cate1.value; // 主分類的值

        let str = "";
        //b;
        for (let item of cates) {
            if (+item.parent_PDcategory_id === +cate1Val1) { //+ cate1轉成字串
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