<?php

namespace models;

class User
{
    private $id;
    private $email;
    private $password;
    private $db;

    public function __construct(\mysqli $db, $email = '', $password = '', $id = 0)
    {
        $this->email = $email;
        $this->password = $password;
        $this->id = $id;
        $this->db = $db;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function load($id)
    {
        /*
         * Загружает информацию пользователя из базы данных по его идентификатору, если такой пользователь существует.
         * При успехе метод возвращает true, иначе - false.
         */
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows == 1) {
            $data = $res->fetch_assoc();
            $this->email = $data['email'];
            $this->password = $data['password'];
            $this->id = $data['id'];
            return true;
        } else {
            return false;
        }
    }

    public function save()
    {
        /*
         * Сохраняет текущий объект пользователя в базе данных.
         * Если идентификатор пользователя равен 0, то выполняется вставка,
         * иначе пользователь обновляется.
         */
        if ($this->id == 0) {
            $stmt = $this->db->prepare("INSERT INTO users (email, password) VALUES (?, ?)");
            $stmt->bind_param('ss', $this->email, $this->password);
            $stmt->execute();
            $this->id = $stmt->insert_id;
        } else {
            $stmt = $this->db->prepare("UPDATE users SET email = ?, password = ? WHERE id = ?");
            $stmt->bind_param('ssi', $this->email, $this->password, $this->id);
            $stmt->execute();
        }
    }

    public function delete()
    {
        /*
         * Удаляет текущего пользователя из базы данных,
         * если его идентификатор не равен 0.
         */
        if ($this->id != 0) {
            $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
            $stmt->bind_param('i', $this->id);
            $stmt->execute();
            $this->id = 0;
        }
    }
}
