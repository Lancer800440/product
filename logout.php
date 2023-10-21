<?php
session_start();

# session_destroy(); # 清除所有的 session 資料

unset($_SESSION['admin']);

# 轉向 redirect
header('Location: login.php');
