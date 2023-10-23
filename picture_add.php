<?php

require './parts/connect_db.php';
$title = '新增商品照片';
$pageName = 'product_picture_add';


$sql4 = "SELECT * FROM product_picture";

$rows4 = $pdo->query($sql4)->fetchAll();

#echo json_encode($rows4, JSON_UNESCAPED_UNICODE);
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>

<div class="container">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form name="form1" onsubmit="sendData(event)">
                        <label for="PDpicture_name" class="form-label">商品照片</label>
                        <input id="PDpicture_name" name="PDpicture_name" style="width: 600px" />
                        <div style="cursor: pointer" onclick="triggerUpload('PDpicture_name')">
                            點選上傳照片
                        </div>
                        <div style="width: 300px">
                            <img src="" alt="" id="PDpicture_name_img" width="100%" />
                        </div>
                        <button type="submit" class="btn btn-primary">確定</button>
                    </form>
                </div>
                <form name="picform" hidden>
                    <input type="file" name="avatar" onchange="uploadFile()" />
                </form>
            </div>
        </div>
    </div>


</div>

<?php include './parts/scripts.php' ?>
<script>
    const PDpicture_name_in = document.form1.PDpicture_name;
    function sendData(e) {
        e.preventDefault(); // 不要讓表單以傳統的方式送出

        // 外觀要回復原來的狀態
        PDpicture_name.style.border = '1px solid #CCCCCC';
        PDpicture_name.nextElementSibling.innerHTML = '';
        // fields.forEach(field => {
        //   field.style.border = '1px solid #CCCCCC';
        //   field.nextElementSibling.innerHTML = '';
        // })    

        // TODO: 資料在送出之前, 要檢查格式
        let isPass = true; // 有沒有通過檢查


        if (!isPass) {
            return; // 沒有通過就不要發送資料
        }

        // 建立只有資料的表單
        const fd = new FormData(document.form1);

        fetch('picture_add-api.php', {
                method: 'POST',
                body: fd, // 送出的格式會自動是 multipart/form-data
            }).then(r => r.json())
            .then(data => {
                console.log({
                    data
                });
                if (data.success) {
                    alert('資料新增成功');
                    location.href = "./picture_list.php"
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

    let uploadFieldId; // 欄位 Id
    // 中轉站
    function triggerUpload(fid) {
        uploadFieldId = fid;
        document.picform.avatar.click();
    }

    function uploadFile() {
        const fd = new FormData(document.picform);
        fetch("upload-img-api.php", {
                method: "POST",
                body: fd, // enctype="multipart/form-data"
            })
            .then((r) => r.json())
            .then((data) => {
                if (data.success) {
                    if (uploadFieldId) {
                        document.form1[uploadFieldId].value = data.file;
                        document.querySelector(`#${uploadFieldId}_img`).src =
                            "/my-proj/add+cate-HTML-1/uploads/" + data.file;
                    }
                }
                uploadFieldId = null;
            });
    }
</script>
<?php include './parts/html-foot.php' ?>