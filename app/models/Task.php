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
