# FixPoint — учебный проект сервисного центра

Проект выполнен на PHP 8, MySQL, HTML, CSS и JavaScript. Клиент может создать заявку и проверить её статус. Сотрудник видит статистику, список заявок и меняет их состояние.

## Запуск через XAMPP

1. Скопировать папку `service-center` в `C:\\xampp\\htdocs\\`.
2. Запустить Apache и MySQL в панели XAMPP.
3. Открыть `http://localhost/phpmyadmin` и импортировать `database.sql`.
4. Проверить настройки подключения в `includes/db.php`.
5. Открыть `http://localhost/service-center/`.

Панель сотрудника: `http://localhost/service-center/admin/`  
Логин: `admin`  
Пароль: `admin123`

Перед публикацией нужно сменить пароль администратора и реквизиты базы данных.
