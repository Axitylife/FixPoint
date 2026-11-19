<?php require_once __DIR__.'/../includes/db.php';require_once __DIR__.'/../includes/functions.php';require_admin();$id=(int)($_GET['id']??0);$allowed=['new','diagnostics','in_progress','ready','completed','cancelled'];$labels=['new'=>'Новая','diagnostics'=>'Диагностика','in_progress'=>'В ремонте','ready'=>'Готова','completed'=>'Выдана','cancelled'=>'Отменена'];
if($_SERVER['REQUEST_METHOD']==='POST'){if(!hash_equals($_SESSION['csrf_token']??'',$_POST['csrf_token']??''))exit('Ошибка формы');$status=$_POST['status']??'';$comment=trim($_POST['admin_comment']??'');if(in_array($status,$allowed,true)){$s=$pdo->prepare('UPDATE repair_requests SET status=?,admin_comment=? WHERE id=?');$s->execute([$status,$comment,$id]);header('Location:request.php?id='.$id.'&saved=1');exit;}}
$s=$pdo->prepare('SELECT * FROM repair_requests WHERE id=?');$s->execute([$id]);$r=$s->fetch();if(!$r){http_response_code(404);exit('Заявка не найдена');}
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?=e($r['request_number'])?></title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <header>
        <div class="container nav"><a class="logo" href="index.php">← К списку</a></div>
    </header>
    <main class="container section narrow">
        <h1><?=e($r['request_number'])?></h1><?php if(isset($_GET['saved'])):?><p class="success">Изменения сохранены.
        </p><?php endif;?><div class="details">
            <p><b>Клиент:</b> <?=e($r['client_name'])?></p>
            <p><b>Телефон:</b> <?=e($r['phone'])?></p>
            <p><b>E-mail:</b> <?=e($r['email'])?></p>
            <p><b>Устройство:</b> <?=e($r['device_type'])?></p>
            <p><b>Неисправность:</b><br><?=nl2br(e($r['problem']))?></p>
        </div>
        <form method="post"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><label>Статус<select
                    name="status"><?php foreach($labels as $k=>$v):?><option value="<?=e($k)?>"
                        <?= $r['status']===$k?'selected':''?>><?=e($v)?></option>
                    <?php endforeach;?></select></label><label>Комментарий сотрудника<textarea name="admin_comment"
                    rows="5"><?=e($r['admin_comment'])?></textarea></label><button class="button">Сохранить</button>
        </form>
    </main>
</body>

</html>