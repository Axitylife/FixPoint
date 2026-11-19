<?php require_once __DIR__.'/../includes/db.php'; require_once __DIR__.'/../includes/functions.php'; require_admin();
$stats=$pdo->query("SELECT COUNT(*) total, SUM(status NOT IN ('completed','cancelled')) active, SUM(status='completed') completed FROM repair_requests")->fetch();
$visits=$pdo->query("SELECT COUNT(DISTINCT visitor_token) unique_visitors, SUM(page_views) views FROM visits")->fetch();
$filter=$_GET['status']??'';$allowed=['new','diagnostics','in_progress','ready','completed','cancelled'];
if(in_array($filter,$allowed,true)){$s=$pdo->prepare('SELECT * FROM repair_requests WHERE status=? ORDER BY created_at DESC');$s->execute([$filter]);$requests=$s->fetchAll();}else{$requests=$pdo->query('SELECT * FROM repair_requests ORDER BY created_at DESC')->fetchAll();}
$labels=['new'=>'Новая','diagnostics'=>'Диагностика','in_progress'=>'В ремонте','ready'=>'Готова','completed'=>'Выдана','cancelled'=>'Отменена'];
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Панель сотрудника</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>

<body>
    <header>
        <div class="container nav"><a class="logo" href="index.php">FixPoint Admin</a>
            <nav><span><?=e($_SESSION['admin_name'])?></span><a href="logout.php">Выйти</a></nav>
        </div>
    </header>
    <main class="container section">
        <h1>Заявки сервисного центра</h1>
        <div class="stats">
            <div><span>Всего заявок</span><b><?= (int)$stats['total']?></b></div>
            <div><span>Активные</span><b><?= (int)$stats['active']?></b></div>
            <div><span>Выполненные</span><b><?= (int)$stats['completed']?></b></div>
            <div><span>Посетители</span><b><?= (int)$visits['unique_visitors']?></b></div>
            <div><span>Просмотры</span><b><?= (int)$visits['views']?></b></div>
        </div>
        <form class="filter"><label>Фильтр по статусу<select onchange="location='?status='+this.value">
                    <option value="">Все</option><?php foreach($labels as $k=>$v):?><option value="<?=e($k)?>"
                        <?= $filter===$k?'selected':''?>><?=e($v)?></option><?php endforeach;?>
                </select></label></form>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>Номер</th>
                        <th>Клиент</th>
                        <th>Устройство</th>
                        <th>Проблема</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody><?php foreach($requests as $r):?><tr>
                        <td><?=e($r['request_number'])?></td>
                        <td><b><?=e($r['client_name'])?></b><br><small><?=e($r['phone'])?></small></td>
                        <td><?=e($r['device_type'])?></td>
                        <td><?=e(mb_strimwidth($r['problem'],0,65,'…'))?></td>
                        <td><?=e(date('d.m.Y',strtotime($r['created_at'])))?></td>
                        <td><span class="status <?=e($r['status'])?>"><?=e($labels[$r['status']])?></span></td>
                        <td><a href="request.php?id=<?=(int)$r['id']?>">Открыть</a></td>
                    </tr><?php endforeach;?></tbody>
            </table>
        </div>
    </main>
</body>

</html>