<?php

require './parts/connect_db.php';
$title = '商品顏色';
$pageName = 'product_color';


$sql3 = "SELECT * FROM product_color";

$rows3 = $pdo->query($sql3)->fetchAll();

#echo json_encode($rows3, JSON_UNESCAPED_UNICODE);
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
                            <span class="input-group-text">商品顏色</span>
                            <select class="form-select" name="PDcolor_id" id="color1" onchange="generateColorList()">
                                <?php foreach ($rows3 as $r) :?>
                                        <option value="<?= $r['PDcolor_id'] ?>"><?= $r['PDcolor_name'] ?></option>
                                <?php
                                endforeach ?>
                            </select>
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
        color1: 1
    };




    const colors = <?= json_encode($rows3, JSON_UNESCAPED_UNICODE) ?>;
    const color1 = document.querySelector('#color1')

    function generateColorList() { //呼叫generateColorList()
        const color1Val = color1.value; // 主分類的值

        let str = "";
        for (let item of colors) {
                str += `<option value="${item.PDcolor_id}">${item.PDcolor_name}</option>`;
            }
        }
    color1.value = initVals.color1; // 設定第一層的初始值
</script>
<?php include './parts/html-foot.php' ?>