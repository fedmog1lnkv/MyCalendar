<?php

namespace models;

class Task
{
    private $id;
    private $theme;
    private $type;
    private $location;
    private $start_date;
    private $duration;
    private $comment;
    private $status;
    private $user;
    private $db;

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

    // Getter для theme
    public function getTheme()
    {
        return $this->theme;
    }

    // Getter для type
    public function getType()
    {
        return $this->type;
    }

    // Getter для location
    public function getLocation()
    {
        return $this->location;
    }

    // Getter для startDate
    public function getStartDate()
    {
        return $this->start_date;
    }

    // Getter для duration
    public function getDuration()
    {
        return $this->duration;
    }

    // Getter для comment
    public function getComment()
    {
        return $this->comment;
    }

    // Getter для status
    public function getStatus()
    {
        return $this->status;
    }

    public function create()
    {
        /*
         * Создать новую задачу
         */
        $stmt = $this->db->prepare('INSERT INTO tasks (user_id, theme, type, location, start_date, duration, comment) VALUES (?, ?, ?, ?, ?, ?, ?)');
        $user_id = $this->user->getId();
        $stmt->bind_param('issssis', $user_id, $this->theme, $this->type, $this->location, $this->start_date, $this->duration, $this->comment);
        $stmt->execute();
        $this->id = $stmt->insert_id;
    }

    public function getAllByUser()
    {
        /*
         * Получить все задачи пользователя
         */
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

    public function delete()
    {
        /*
        * Удалить задачу
        */
        $stmt = $this->db->prepare('DELETE FROM tasks WHERE id = ? AND user_id = ?');
        $user_id = $this->user->getId();
        $stmt->bind_param('ii', $this->id, $user_id);
        $stmt->execute();
    }


    public function update()
    {
        /*
        * Обновление информации о задаче в базе данных
        */
        $stmt = $this->db->prepare('UPDATE tasks SET user_id = ?, theme = ?, type = ?, location = ?, start_date = ?, duration = ?, comment = ?, status = ? WHERE id = ?');
        $user_id = $this->user->getId();
        $stmt->bind_param('issssisii', $user_id, $this->theme, $this->type, $this->location, $this->start_date, $this->duration, $this->comment, $this->status, $this->id);
        $stmt->execute();

        return $stmt->affected_rows > 0;
    }

}
