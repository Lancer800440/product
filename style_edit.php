<?php

require './parts/connect_db.php';

// 取得資料的 PK
$PDstyle_id = isset($_GET['PDstyle_id']) ? intval($_GET['PDstyle_id']) : 0;

if (empty($PDstyle_id)) {
    header('Location: style_list.php');
    exit; // 結束程式
}

$sql2 = "SELECT * FROM product_style WHERE PDstyle_id={$PDstyle_id}";
$row = $pdo->query($sql2)->fetch();
if (empty($row)) {
    header('Location: style_list.php');
    exit; // 結束程式
}

$sql2 = "SELECT * FROM product_style";
$rows2 = $pdo->query($sql2)->fetchAll();


#echo json_encode($row, JSON_UNESCAPED_UNICODE);
$title = '編輯造型資料';

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
                    <form name="form1" onsubmit="sendData(event)">
                        <input type="hidden" name="PDstyle_id" value="<?= $row['PDstyle_id'] ?>">

                        <div class="card-title">編輯造型名稱</div>
                        <div class="input-group mb-3">
                            <label for="PDstyle_name" class="form-label"></label>
                            <input type="text" class="form-control" id="PDstyle_name" name="PDstyle_name" value="<?= htmlentities($row['PDstyle_name']) ?>">
                            <div class="form-text"></div>
                        </div>

                        <button type="submit" class="btn btn-primary">確定</button>
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

        fetch('style_edit-api.php', {
                method: 'POST',
                body: fd, // 送出的格式會自動是 multipart/form-data
            }).then(r => r.json())
            .then(data => {
                console.log({
                    data
                });
                if (data.success) {
                    alert('資料編輯成功');
                    location.href = "./style_list.php"
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

</script>
<?php include './parts/html-foot.php' ?>