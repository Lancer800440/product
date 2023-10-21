<?php

require './parts/connect_db.php';
$title = '新增商品顏色';
$pageName = 'product_color_add';


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
                    <form name="form1" onsubmit="sendData(event)">
                        <div class="mb-3">
                            <label for="PDcolor_name" class="form-label">新增產品顏色</label>
                            <input type="text" class="form-control" id="PDcolor_name" name="PDcolor_name">
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
    const PDcolor_name_in = document.form1.PDcolor_name;
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
        PDcolor_name_in.style.border = '1px solid #CCCCCC';
        PDcolor_name_in.nextElementSibling.innerHTML = '';
        // fields.forEach(field => {
        //   field.color.border = '1px solid #CCCCCC';
        //   field.nextElementSibling.innerHTML = '';
        // })    

        // TODO: 資料在送出之前, 要檢查格式
        let isPass = true; // 有沒有通過檢查

        //判斷name的格式 以及給出提醒


        /*
        if (name_in.value.length < 2) {
          isPass = false;
          name_in.color.border = '2px solid red';
          name_in.nextElementSibling.innerHTML = '請填寫正確的姓名';
          //属性返回指定元素之后的下一个兄弟元素（相同节点树层中的下一个元素节点）
        }  

        //判斷email 如果不是對的內容
        if (!validateEmail(email_in.value)) {
          isPass = false;
          email_in.color.border = '2px solid red';
          email_in.nextElementSibling.innerHTML = '請填寫正確的 Email';
        }
        */

        // 非必填  如果有寫內容且內容錯誤 才要跳出錯誤訊息
        // if (mobile_in.value && !validateMobile(mobile_in.value)) {
        //   isPass = false;
        //   mobile_in.color.border = '2px solid red';
        //   mobile_in.nextElementSibling.innerHTML = '請填寫正確的手機號碼';
        // }

        if (!isPass) {
            return; // 沒有通過就不要發送資料
        }

        // 建立只有資料的表單
        const fd = new FormData(document.form1);

        fetch('color_add-api.php', {
                method: 'POST',
                body: fd, // 送出的格式會自動是 multipart/form-data
            }).then(r => r.json())
            .then(data => {
                console.log({
                    data
                });
                if (data.success) {
                    alert('資料新增成功');
                    location.href = "./color_list.php"
                } else {
                    //alert('發生問題');
                    for (let n in data.errors) {
                        console.log(`n: ${n}`);
                        if (document.form1[n]) {
                            const input = document.form1[n];
                            input.color.border = '2px solid red';
                            input.nextElementSibling.innerHTML = data.errors[n];
                        }
                    }
                }
            })
            .catch(ex => console.log(ex))
    }
</script>
<?php include './parts/html-foot.php' ?>