<?php
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
track_visit($pdo);
$services = $pdo->query('SELECT * FROM services WHERE is_active = 1 ORDER BY id')->fetchAll();
?>
<!doctype html>
<html lang="ru">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>FixPoint — сервисный центр</title>
    <meta name="description"
        content="Ремонт компьютеров, ноутбуков и телефонов. Онлайн-заявка и проверка статуса ремонта.">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <header>
        <div class="container nav"><a class="logo" href="index.php">FixPoint</a>
            <nav><a href="#services">Услуги</a><a href="#request">Заявка</a><a href="status.php">Статус ремонта</a><a
                    href="admin/login.php">Сотрудникам</a></nav>
        </div>
    </header>
    <main>
        <section class="hero">
            <div class="container hero-grid">
                <div><span class="tag">Сервисный центр в Москве</span>
                    <h1>Ремонт техники без лишних ожиданий</h1>
                    <p>Диагностируем устройство, согласуем стоимость и сообщаем о каждом этапе ремонта.</p><a
                        class="button" href="#request">Оставить заявку</a>
                </div>
                <div class="hero-card"><b>Почему выбирают нас</b>
                    <ul>
                        <li>Бесплатная первичная диагностика</li>
                        <li>Гарантия на выполненные работы</li>
                        <li>Проверка статуса по номеру заявки</li>
                    </ul>
                </div>
            </div>
        </section>
        <section id="services" class="container section">
            <h2>Наши услуги</h2>
            <div class="cards"><?php foreach ($services as $service): ?><article class="card">
                    <h3><?=e($service['name'])?></h3>
                    <p><?=e($service['description'])?></p><b>от
                        <?=number_format((float)$service['price_from'],0,',',' ')?> ₽</b>
                </article><?php endforeach; ?></div>
        </section>
        <section id="request" class="section muted">
            <div class="container form-wrap">
                <div>
                    <h2>Оставить заявку</h2>
                    <p>Опишите неисправность. После регистрации вы получите номер заявки для проверки статуса.</p>
                </div>
                <form id="requestForm" action="create_request.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>">
                    <label>Ваше имя<input name="client_name" required maxlength="80"></label>
                    <label>Телефон<input name="phone" required maxlength="25" placeholder="+7 999 000-00-00"></label>
                    <label>Электронная почта<input type="email" name="email" maxlength="120"></label>
                    <label>Тип устройства<select name="device_type" required>
                            <option value="">Выберите</option>
                            <option>Ноутбук</option>
                            <option>Компьютер</option>
                            <option>Смартфон</option>
                            <option>Планшет</option>
                            <option>Другое</option>
                        </select></label>
                    <label class="full">Описание неисправности<textarea name="problem" required maxlength="1000"
                            rows="5"></textarea><small><span id="counter">0</span>/1000</small></label>
                    <label class="checkbox full"><input type="checkbox" required> Я согласен на обработку персональных
                        данных</label>
                    <button class="button full" type="submit">Отправить заявку</button>
                    <p id="formError" class="error full"></p>
                </form>
            </div>
        </section>
    </main>
    <footer>
        <div class="container"><b>FixPoint</b><span>Учебный проект сервисного центра</span><span>+7 (495)
                000-00-00</span></div>
    </footer>
    <script src="assets/app.js"></script>
</body>

</html>