<?php
require_once('app/controllers/usersController.php');

if (!isset($_COOKIE["user_id"])) {

    // Создание объекта контроллера
    $usersController = new usersController();

    // Обработка POST-запроса на регистрацию пользователя
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/user') {
        $usersController->store();
    } // Обработка GET-запроса на регистрацию пользователя или при первом переходе на сайт
    else if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_SERVER['REQUEST_URI'] === '/register' || $_SERVER['REQUEST_URI'] === '/')) {
        $usersController->register();
    } // Обработка POST-запроса на авторизацию пользователя
    else if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === '/login') {
        $usersController->authenticate();
    } // Обработка GET-запроса на вывод формы авторизации
    else if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/login') {
        $usersController->login();
    }

} // Обработка GET-запроса на выход пользователя
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === '/logout') {

    $usersController = new usersController();
    $usersController->logout();

} else {

    echo "Вы авторизованы!";

}