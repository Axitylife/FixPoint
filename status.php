<?php require_once __DIR__.'/includes/db.php'; require_once __DIR__.'/includes/functions.php';
$number=trim($_GET['number']??''); $request=null; if($number!==''){ $s=$pdo->prepare('SELECT request_number,device_type,status,created_at,updated_at FROM repair_requests WHERE request_number=?'); $s->execute([$number]); $request=$s->fetch(); }
$labels=['new'=>'Новая','diagnostics'=>'Диагностика','in_progress'=>'В ремонте','ready'=>'Готова','completed'=>'Выдана','cancelled'=>'Отменена']; ?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Статус ремонта — FixPoint</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header>
        <div class="container nav"><a class="logo" href="index.php">FixPoint</a></div>
    </header>
    <main class="container section narrow">
        <h1>Проверка статуса</h1>
        <form class="search-form"><label>Номер заявки<input name="number" value="<?=e($number)?>"
                    placeholder="FP-260925-1234" required></label><button class="button">Найти</button></form>
        <?php if($number!=='' && !$request): ?><p class="alert">Заявка с таким номером не найдена.</p>
        <?php elseif($request): ?><section class="status-card">
            <h2><?=e($request['request_number'])?></h2>
            <p>Устройство: <b><?=e($request['device_type'])?></b></p>
            <p>Текущий статус: <span
                    class="status <?=e($request['status'])?>"><?=e($labels[$request['status']]??$request['status'])?></span>
            </p>
            <p>Создана: <?=e(date('d.m.Y H:i',strtotime($request['created_at'])))?></p>
        </section><?php endif; ?>
    </main>
</body>

</html>