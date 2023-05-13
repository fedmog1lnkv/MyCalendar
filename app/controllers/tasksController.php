<?php
include('app/models/Task.php');

use models\Task;
use models\User;

class taskController
{
    public function index()
    {
        // Получаем пользователя из базы данных
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $userId = $_COOKIE['user_id'];
        $user = new User($db, id: $userId);
        $user->getUserEmailAndPasswordById($userId);

        // Получаем все задачи из базы данных для данного пользователя
        $task = new Task($db);
        $task->setUser($user);
        $tasks = $task->getAllByUser();

        // Объединяем данные пользователя и список задач в один массив
        $data = [
            'user' => $user,
            'tasks' => $tasks
        ];

        // Передаём массив данных в представление
        require_once('app/views/task/index.php');
    }

    public function filter($filters)
    {
        // Получаем пользователя из базы данных
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $userId = $_COOKIE['user_id'];
        $user = new User($db, id: $userId);
        $user->getUserEmailAndPasswordById($userId);

        //Получаем данные из формы для фильтрации
        $task = new Task($db);
        $task->setUser($user);
        $tasks = $task->getFiltered($filters);

        // Объединяем данные пользователя и отфильтрованный список задач в один массив
        $data = [
            'user' => $user,
            'tasks' => $tasks
        ];
//        print_r($tasks);
        // Передаём массив данных в представление
        require_once('app/views/task/index.php');
    }

    public function show($id)
    {
        // получаем задачу из базы данных и передаём её в представление
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $task = new Task($db);
        $task->getById($id);
        require_once('app/views/task/show.php');
    }

    public function create()
    {
        // выводим форму для создания задачи
        require_once('app/views/task/create.php');
    }

    public function store()
    {
        // получаем данные из формы
        // Проверяем, была ли отправлена форма
        if (isset($_POST['theme'])) {
            $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            $userId = $_COOKIE['user_id'];
            $user = new User($db, id: $userId);

            // Создаем экземпляр класса Task, используя данные из формы
            $task = new Task(
                $db,
                $user,
                $_POST['theme'],
                $_POST['type'],
                $_POST['location'],
                isset($_POST['start_date']) ? date('Y-m-d H:i:s', strtotime($_POST['start_date'])) : null,
                $_POST['duration'],
                $_POST['comment']
            );


            // сохраняем задачу в базе данных
            $task->create();

            // перенаправляем на главную страницу задач
            header('Location: /tasks');
        }
    }


    public function edit($id)
    {
        // получаем задачу из базы данных и передаём её в представление
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $task = new Task($db, id: $id);
        $task->getById($id);
        require_once('app/views/task/edit.php');
    }

    public function update($id)
    {
        // обновляем задачу в базе данных
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        $userId = $_COOKIE['user_id'];
        $user = new User($db, id: $userId);

        $task = new Task(
            $db,
            $user,
            $_POST['theme'],
            $_POST['type'],
            $_POST['location'],
            isset($_POST['start_date']) ? date('Y-m-d H:i:s', strtotime($_POST['start_date'])) : null,
            $_POST['duration'],
            $_POST['comment'],
            $_POST['status'],
            $id
        );

        $task->update();

        // перенаправляем на главную страницу задач
        header('Location: /tasks');
    }

    public function delete($id)
    {
        // получаем id задачи из GET-параметра

        // удаляем задачу из базы данных
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $task = new Task($db, id: $id);

        $userId = $_COOKIE['user_id'];
        $user = new User($db, id: $userId);
        $user->getUserEmailAndPasswordById($userId);
        $task->setUser($user);
        print_r($user);

        $task->delete();

        // перенаправляем на главную страницу задач
        header('Location: /tasks');
    }
}
