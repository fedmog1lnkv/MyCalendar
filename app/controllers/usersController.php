<?php
include('app/models/User.php');

use models\User;

class usersController
{

    /**
     * Выводит форму для регистрации пользователя.
     * Функция вызывается при GET-запросе на URL "/register".
     */
    public function register()
    {
        // Подключаем файл с шаблоном формы для регистрации пользователя.
        require_once('app/views/user/register.php');
    }

    /**
     * Создает нового пользователя на основе данных, полученных из формы,
     * сохраняет его в базе данных и перенаправляет на страницу авторизации в случае успеха.
     * Выдает ошибку, если пользователь с таким email уже существует в базе данных.
     * Функция вызывается при POST-запросе на URL "/register".
     */
    public function store()
    {
        // Получаем данные из формы
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Создаём нового пользователя
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user = new User($db, $email, $password);

        if ($user->exists()) {
            require_once('app/views/user/register_error.php');
        } else {
            // Сохраняем пользователя в базе данных
            $user->save();

            // Устанавливаем cookie с id пользователя на 30 дней
            setcookie("user_id", $user->getUserIdByEmailAndPassword($email, $password), time() + (30 * 24 * 60 * 60), "/");

            // Перенаправляем на страницу авторизации
            $this->login();
        }
    }

    /**
     * Выводит форму для авторизации пользователя.
     * Функция вызывается при GET-запросе на URL "/login".
     */
    public function login()
    {
        // Подключаем файл с шаблоном формы для авторизации пользователя.
        require_once('app/views/user/login.php');
    }

    /**
     * Выводит сообщение об ошибке авторизации.
     * Функция вызывается при GET-запросе на URL "/login_error".
     */
    public function login_error()
    {
        // Подключаем файл с шаблоном сообщения об ошибке авторизации пользователя.
        require_once('app/views/user/login_error.php');
    }

    /**
     * Авторизует пользователя и устанавливает cookie с id пользователя на 30 дней в случае успеха.
     * Выдает ошибку, если пользователь с указанным email и паролем не найден в базе данных.
     * Функция вызывается при POST-запросе на URL "/login".
     */
    public function authenticate()
    {
        // получаем данные из формы
        $email = $_POST['email'];
        $password = $_POST['password'];
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user = new User($db, $email, $password);

        // проверяем, есть ли пользователь с таким email и паролем в базе данных
        if ($user->exists($email, $password)) {
            // если есть – авторизуем его и устанавливаем cookie с id пользователя на 30 дней
            setcookie("user_id", $user->getUserIdByEmailAndPassword($email, $password), time() + (30 * 24 * 60 * 60), "/");

            // перенаправляем на главную страницу
            header('Location: /');
        } else {
            // если нет – выводим сообщение об ошибке
            header('Location: /login_error');
        }
    }

    /**
     * Разлогинивает пользователя путём удаления cookie и перенаправляет на страницу авторизации.
     * Функция вызывается при GET-запросе на URL "/logout".
     */
    public function logout()
    {
        // Удаляем cookie с id пользователя.
        setcookie("user_id", "", time() - 3600, "/");

        // Перенаправляем на страницу авторизации.
        header('Location: /login');
    }
}
