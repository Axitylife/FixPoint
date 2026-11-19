<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php'); exit; }
if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) { http_response_code(403); exit('Ошибка проверки формы'); }
$name = trim($_POST['client_name'] ?? ''); $phone = trim($_POST['phone'] ?? '');
$email = trim($_POST['email'] ?? ''); $device = trim($_POST['device_type'] ?? ''); $problem = trim($_POST['problem'] ?? '');
$allowed = ['Ноутбук','Компьютер','Смартфон','Планшет','Другое'];
if ($name === '' || $phone === '' || $problem === '' || !in_array($device, $allowed, true) || ($email && !filter_var($email, FILTER_VALIDATE_EMAIL))) {
    $_SESSION['flash'] = 'Проверьте заполнение обязательных полей.'; header('Location: index.php#request'); exit;
}
$number = 'FP-' . date('ymd') . '-' . random_int(1000, 9999);
$stmt = $pdo->prepare('INSERT INTO repair_requests (request_number, client_name, phone, email, device_type, problem) VALUES (?, ?, ?, ?, ?, ?)');
$stmt->execute([$number, $name, $phone, $email ?: null, $device, $problem]);
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Заявка принята</title>
    <link rel="stylesheet" href="assets/style.css">
</head>

<body class="center-page">
    <main class="result-card">
        <div class="success-icon">✓</div>
        <h1>Заявка принята</h1>
        <p>Спасибо, <?=e($name)?>. Номер вашей заявки:</p>
        <div class="request-number"><?=e($number)?></div>
        <p>Сохраните его, чтобы проверять статус ремонта.</p><a class="button"
            href="status.php?number=<?=urlencode($number)?>">Проверить статус</a><a class="text-link"
            href="index.php">Вернуться на главную</a>
    </main>
</body>

</html>