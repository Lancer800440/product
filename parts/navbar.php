<?php
if (!isset($pageName)) {
  $pageName = '';
}
?>
<style>
  nav.navbar ul.navbar-nav .nav-link.active {
    background-color: blue;
    color: white;
    border-radius: 6px;
    font-weight: 600;
  }
</style>
<div class="container">
  <nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
      <!-- <a class="navbar-brand" href="">產品明細</a> -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'list' ? 'active' : '' ?>" href="list.php">產品列表</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'add' ? 'active' : '' ?>" href="add.php">新增產品</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'cate2_list' ? 'active' : '' ?>" href="cate2_list.php">產品類別列表</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'style_list' ? 'active' : '' ?>" href="style_list.php">產品造型列表</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $pageName == 'color_list' ? 'active' : '' ?>" href="color_list.php">產品顏色列表</a>
          </li>
        </ul>
        
        <ul class="navbar-nav mb-2 mb-lg-0">
          <?php if (isset($_SESSION['admin'])) : ?>
            <li class="nav-item">
              <a class="nav-link"><?= $_SESSION['admin']['nickname'] ?></a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="logout.php">登出</a>
            </li>
          <?php else : ?>
            <li class="nav-item">
              <a class="nav-link <?= $pageName == 'login' ? 'active' : '' ?>" href="login.php">登入</a>
            </li>
          <?php endif ?>

        </ul>
      </div>
    </div>
  </nav>
</div>