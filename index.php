<?php
include('app/config.php');
// Подключаем файлы классов
require_once 'app/controllers/usersController.php';
require_once 'app/controllers/tasksController.php';

// Создаём объекты контроллеров
$usersController = new usersController();
$taskController = new taskController();

// Определяем запрошенный URL и HTTP-метод
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

if (!isset($_COOKIE['user_id'])) {
    // Маршрутизация запросов для пользователей
    if ($method === 'POST' && $url === '/user') {
        // Обработка POST-запроса на регистрацию пользователя
        $usersController->store();
    } elseif ($method === 'GET' && ($url === '/register' || $url === '/')) {
        // Обработка GET-запроса на регистрацию пользователя или при первом переходе на сайт
        $usersController->register();
    } elseif ($method === 'POST' && $url === '/login') {
        // Обработка POST-запроса на авторизацию пользователя
        $usersController->authenticate();
    } elseif ($method === 'GET' && $url === '/login') {
        // Обработка GET-запроса на вывод формы авторизации
        $usersController->login();
    }elseif ($method === 'GET' && $url === '/login_error'){
        //  Обработка GET-запроса на вывод формы авторизации с ошибкой
        $usersController->login_error();
    }

} else {
// Маршрутизация запросов для задач
    if ($method === 'GET' && strpos($url, '/tasks/edit/') === 0) {
        // Обработка GET-запроса на вывод формы редактирования задачи (например, "/tasks/edit/42")
        $id = substr($url, strrpos($url, '/') + 1);
        $taskController->edit($id);
    } elseif ($method === 'POST' && strpos($url, '/tasks/update/') === 0) {
        // Обработка POST-запроса на сохранение изменений задачи (например, "/tasks/update/42")
        $id = substr($url, strrpos($url, '/') + 1);
        $taskController->update($id);
    } elseif ($method === 'GET' && $url === '/tasks/create') {
        // Обработка GET-запроса на вывод формы создания новой задачи
        $taskController->create();
    } elseif ($method === 'GET' && $url === '/tasks/filter') {
        // Получаем параметры фильтра из GET-запроса
        $start_date = !empty($_GET['start_date']) ? trim($_GET['start_date']) : '';
        $status = !empty($_GET['status']) ? trim($_GET['status']) : '';

        // Формируем массив фильтров
        $filters = [
            'start_date' => $start_date,
            'status' => $status
        ];

        // Обработка GET-запроса на вывод фильтрованных задач
        $taskController->filter($filters);
    }
    elseif ($method === 'GET' && strpos($url, '/tasks/') === 0) {
        // Обработка GET-запроса на просмотр одной задачи (например, "/tasks/42")
        $id = substr($url, strrpos($url, '/') + 1);
        $taskController->show($id);
    } elseif ($method === 'POST' && $url === '/tasks') {
        // Обработка POST-запроса на добавление новой задачи
        $taskController->store();
    } elseif ($method === 'POST' && strpos($url, '/tasks/delete/') === 0) {
        // Обработка POST-запроса на удаление задачи (например, "/tasks/delete/42")
        $id = substr($url, strrpos($url, '/') + 1);
        $taskController->delete($id);
    } elseif ($method === 'GET' && ($url === '/tasks' || $url === '/')) {
        // Обработка GET-запроса на список задач
        $taskController->index();
    } elseif ($method === 'GET' && $url === '/logout') {
        $usersController->logout();
    } else {
        header('HTTP/1.0 404 Not Found');
        echo 'Page not found.';
    }
}
