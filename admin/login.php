<?php require_once __DIR__.'/../includes/db.php'; require_once __DIR__.'/../includes/functions.php';
if(!empty($_SESSION['admin_id'])){header('Location: index.php');exit;} $error='';
if($_SERVER['REQUEST_METHOD']==='POST'){ $s=$pdo->prepare('SELECT * FROM admins WHERE login=?');$s->execute([trim($_POST['login']??'')]);$a=$s->fetch();if($a&&password_verify($_POST['password']??'',$a['password_hash'])){session_regenerate_id(true);$_SESSION['admin_id']=$a['id'];$_SESSION['admin_name']=$a['name'];header('Location:index.php');exit;}$error='Неверный логин или пароль';}
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Вход — FixPoint</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body class="center-page">
    <form class="login-card" method="post"><a class="logo" href="../index.php">FixPoint</a>
        <h1>Панель сотрудника</h1><?php if($error):?><p class="error"><?=e($error)?></p><?php endif;?><label>Логин<input
                name="login" required></label><label>Пароль<input type="password" name="password"
                required></label><button class="button">Войти</button><small>Демо: admin / admin123</small>
    </form>
</body>

</html>