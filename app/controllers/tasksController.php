<?php
include('app/models/Task.php');

use models\Task;
use models\User;

class taskController
{
    /**
     * Получает данные пользователя и все его задачи из базы данных и передает их в представление.
     * Функция вызывается при открытии главной страницы сайта (GET-запрос к URL "/").
     */
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

    /**
     * Фильтрует список задач по указанным параметрам и передает данные пользователя и отфильтрованный список задач в представление.
     * Функция вызывается при отправке формы фильтрации на главной странице сайта (POST-запрос к URL "/filter").
     *
     * @param array $filters Ассоциативный массив с параметрами фильтрации задач (ключ - имя поля, значение - значение поля).
     */
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

        // Передаём массив данных в представление
        require_once('app/views/task/index.php');
    }

    /**
     * Отображает информацию о задаче с указанным идентификатором на странице "Просмотр задачи".
     * Функция вызывается при переходе пользователя по ссылке на конкретную задачу (GET-запрос к URL "/task/show/{id}").
     *
     * @param int $id Идентификатор задачи.
     */
    public function show($id)
    {
        // получаем задачу из базы данных и передаём её в представление
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $task = new Task($db);
        $task->getById($id);
        require_once('app/views/task/show.php');
    }

    /**
     * Отображает форму для создания новой задачи на странице "Создание задачи".
     * Функция вызывается при переходе пользователя по ссылке на страницу "Создание задачи" (GET-запрос к URL "/task/create").
     */
    public function create()
    {
        // выводим форму для создания задачи
        require_once('app/views/task/create.php');
    }

    /**
     * Обрабатывает данные формы создания задачи, сохраняет новую задачу в базе данных и перенаправляет на страницу списка задач.
     * Функция вызывается при отправке POST-запроса на URL "/task/store".
     */
    public function store()
    {
        // Проверяем, была ли отправлена форма методом POST.
        if (isset($_POST['theme'])) {
            // Создаем соединение с базой данных MySQL.
            $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            // Получаем идентификатор пользователя, добавляющего новую задачу, из куки.
            $userId = $_COOKIE['user_id'];

            // Создаем экземпляр класса User по переданному идентификатору.
            $user = new User($db, id: $userId);

            // Создаем экземпляр класса Task, используя данные из формы.
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

            // Сохраняем задачу в базе данных.
            $task->create();

            // Перенаправляем пользователя на главную страницу задач.
            header('Location: /tasks');
        }
    }

    /**
     * Отображает страницу редактирования задачи с переданным идентификатором.
     * Функция вызывается при GET-запросе на URL "/task/edit/{id}", где "{id}" - идентификатор редактируемой задачи.
     *
     * @param int $id Идентификатор редактируемой задачи.
     */
    public function edit($id)
    {
        // Получаем задачу из базы данных и передаём её в представление
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $task = new Task($db, id: $id);
        $task->getById($id);

        // Подключаем файл представления для отображения страницы редактирования задачи
        require_once('app/views/task/edit.php');
    }


    /**
     * Обновляет задачу с указанным идентификатором в базе данных.
     * Функция вызывается при POST-запросе на URL "/task/update/{id}", где "{id}" - идентификатор обновляемой задачи.
     * Перенаправляет пользователя на главную страницу задач после успешного обновления.
     *
     * @param int $id Идентификатор обновляемой задачи.
     */
    public function update($id)
    {
        // Создаем соединение с базой данных MySQL.
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        // Получаем идентификатор пользователя из cookie и создаем экземпляр класса User по этому идентификатору.
        $userId = $_COOKIE['user_id'];
        $user = new User($db, id: $userId);

        // Создаем экземпляр класса Task и заполняем его свойства значениями из POST-запроса.
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

        // Вызываем метод update() для объекта класса Task, чтобы обновить задачу в базе данных.
        $task->update();

        // Перенаправляем пользователя на главную страницу задач.
        header('Location: /tasks');
    }

    /**
     * Удаляет задачу с указанным идентификатором из базы данных.
     * Функция вызывается при GET-запросе на URL "/task/delete/{id}", где "{id}" - идентификатор удаляемой задачи.
     * Перенаправляет пользователя на главную страницу задач после успешного удаления.
     *
     * @param int $id Идентификатор удаляемой задачи.
     */
    public function delete($id)
    {
        $db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $task = new Task($db, id: $id);

        $userId = $_COOKIE['user_id'];
        $user = new User($db, id: $userId);
        $user->getUserEmailAndPasswordById($userId);

        $task->setUser($user);

        $task->delete();

        // Перенаправляем на главную страницу задач
        header('Location: /tasks');
    }
}
