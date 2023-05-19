<?php

namespace models;

class Task
{
    private $id; // Идентификатор задачи
    private $theme; // Тема задачи
    private $type; // Тип задачи
    private $location; // Место выполнения задачи
    private $start_date; // Дата начала задачи
    private $duration; // Продолжительность задачи
    private $comment; // Комментарий к задаче
    private $status; // Статус задачи
    private $user; // Ответственный пользователь за задачу
    private $db; // Ссылка на объект базы данных


    public function __construct(\mysqli $db, User $user = null, $theme = '', $type = '', $location = '', $start_date = null, $duration = 0, $comment = '', $status = 'in_work', $id = 0)
    {
        $this->theme = $theme;
        $this->type = $type;
        $this->location = $location;
        $this->start_date = $start_date;
        $this->duration = $duration;
        $this->comment = $comment;
        $this->status = $status;
        $this->user = $user;
        $this->id = $id;
        $this->db = $db;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTheme()
    {
        return $this->theme;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getStatus()
    {
        return $this->status;
    }


    /**
     * Создает новую задачу в базе данных
     *
     * @return void
     */
    public function create()
    {
        $stmt = $this->db->prepare('INSERT INTO tasks (user_id, theme, type, location, start_date, duration, comment) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $user_id = $this->user->getId();
        $stmt->bind_param('issssis', $user_id, $this->theme, $this->type, $this->location, $this->start_date, $this->duration, $this->comment);
        $stmt->execute();
        // Установка идентификатора задачи равным возвращенному значению из базы данных
        $this->id = $stmt->insert_id;
    }

    /**
     * Возвращает массив всех задач пользователя
     *
     * @return array Массив объектов задач
     */
    public function getAllByUser()
    {
        $stmt = $this->db->prepare('SELECT * FROM tasks WHERE user_id = ?');
        $user_id = $this->user->getId();
        $stmt->bind_param('i', $user_id);
        $stmt->execute();

        $result = $stmt->get_result();

        $tasks = array();
        while ($data = $result->fetch_assoc()) {
            $task = new Task(
                $this->db,
                null,
                $data['theme'],
                $data['type'],
                $data['location'],
                $data['start_date'],
                $data['duration'],
                $data['comment'],
                $data['status'],
                $data['id']
            );
            $tasks[] = $task;
        }

        return $tasks;
    }

    /**
     * Возвращает массив задач, отфильтрованных по статусу и/или дате начала, для пользователя
     *
     * @param array $filters Ассоциативный массив фильтров (status - статус задачи, start_date - дата начала задачи)
     *
     * @return array Массив объектов задач
     */
    public function getFiltered($filters)
    {
        $query = "SELECT * FROM tasks WHERE user_id = '{$this->user->getId()}'";

        // Проверяем, задан ли фильтр по статусу
        if (!empty($filters['status'])) {
            $status = $this->db->real_escape_string(trim($filters['status']));
            $query .= " AND `status` = '{$status}'";
        }

        // Проверяем, задан ли фильтр по дате и времени начала задачи
        if (!empty($filters['start_date'])) {
            $start_date = date('Y-m-d', strtotime($filters['start_date']));
            $query .= " AND DATE(`start_date`) = '{$start_date}'";
        }

        $result = $this->db->query($query);

        $tasks = [];
        while ($row = $result->fetch_assoc()) {
            $tasks[] = new Task(
                $this->db,
                $this->user,
                $row['theme'],
                $row['type'],
                $row['location'],
                $row['start_date'],
                $row['duration'],
                $row['comment'],
                $row['status'],
                $row['id']
            );
        }

        return $tasks;
    }

    /**
     * Возвращает объект задачи с указанным идентификатором
     *
     * @param int $id Идентификатор задачи
     *
     * @return void
     */
    public function getById($id)
    {
        $query = "SELECT * FROM tasks WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 0) {
            die('Задача не найдена');
        }
        $data = $result->fetch_assoc();
        $this->id = $id;
        $this->theme = $data['theme'];
        $this->type = $data['type'];
        $this->location = $data['location'];
        $this->start_date = $data['start_date'];
        $this->duration = $data['duration'];
        $this->comment = $data['comment'];
        $this->status = $data['status'];
    }


    /**
     * Возвращает статус задачи в текстовом виде
     *
     * @return string Текстовое представление статуса задачи ('Выполняется', 'Выполнена' или 'Не выполнена')
     */
    public function getNormalStatus()
    {
        switch ($this->status) {
            case  'in_work':
                return 'Выполняется';
                break;
            case  'done':
                return 'Выполнена';
                break;
            default:
                return 'Не выполнена';
                break;
        }
    }

    /**
     * Возвращает тип задачи в текстовом виде
     *
     * @return string Текстовое представление типа задачи ('Встреча', 'Звонок', 'Совещание' или 'Дело')
     */
    public function getNormalType()
    {
        switch ($this->type) {
            case  'meeting':
                return 'Встреча';
                break;
            case  'call':
                return 'Звонок';
                break;
            case  'conference':
                return 'Совещание';
                break;
            default:
                return 'Дело';
                break;
        }
    }

    /**
     * Удаляет задачу из базы данных
     *
     * @return void
     */
    public function delete()
    {
        $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
        $user_id = $this->user->getId();
        $stmt->bind_param('ii', $this->id, $user_id);
        $stmt->execute();
    }

    /**
     * Обновляет информацию о задаче в базе данных
     *
     * @return bool Возвращает true, если обновление прошло успешно; в противном случае - false.
     */
    public function update()
    {
        $stmt = $this->db->prepare('UPDATE tasks SET user_id = ?, theme = ?, type = ?, location = ?, start_date = ?, duration = ?, comment = ?, status = ? WHERE id = ?');
        $user_id = $this->user->getId();
        echo $this->status;
        $stmt->bind_param('issssissi', $user_id, $this->theme, $this->type, $this->location, $this->start_date, $this->duration, $this->comment, $this->status, $this->id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

}
