<?php
include('app/models/User.php');

use models\User;

class usersController
{

    public function register()
    {
        // выводим форму для регистрации пользователя
        require_once('app/views/user/register.php');
    }

    public function store()
    {
        // получаем данные из формы
        $email = $_POST['email'];
        $password = $_POST['password'];

        // создаём нового пользователя
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $user = new User($db, $email, $password);

        if ($user->exists()) {
            require_once('app/views/user/register_error.php');
        } else {
            // сохраняем пользователя в базе данных
            $user->save();

            // устанавливаем cookie с id пользователя на 30 дней
            setcookie("user_id", $user->getUserIdByEmailAndPassword($email, $password), time() + (30 * 24 * 60 * 60), "/");

            // перенаправляем на страницу авторизации
            $this->login();
        }
    }

    public function login()
    {
        // выводим форму для авторизации пользователя
        require_once('app/views/user/login.php');
    }

    public function login_error()
    {
        // выводим форму для авторизации пользователя
        require_once('app/views/user/login_error.php');
    }

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

    public function logout()
    {
        // разлогиниваем пользователя путём удаления cookie
        setcookie("user_id", "", time() - 3600, "/");

        // перенаправляем на страницу авторизации
        header('Location: /login');
    }
}
