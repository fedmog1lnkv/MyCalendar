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

    public function getUserEmailAndPasswordById($id)
    {
        /*
         * Возвращает email и password пользователя из базы данных по его id, если такой пользователь существует.
         * При успехе метод возвращает массив ['email' => $email, 'password' => $password], иначе - false.
         */
        $stmt = $this->db->prepare("SELECT email, password FROM users WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows == 1) {
            $data = $res->fetch_assoc();
            return ['email' => $data['email'], 'password' => $data['password']];
        } else {
            return false;
        }
    }


    public function getUserIdByEmailAndPassword($email, $password)
    {
        /*
         * Возвращает id пользователя из базы данных по email и password.
         * Если пользователь не найден или пароль неверный, метод возвращает false.
         */
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param('ss', $email, $password);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows == 1) {
            $row = $res->fetch_assoc();
            return $row['id'];
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

    public function exists()
    {
        /*
         * Проверяет, существует ли пользователь с данным email и password в базе данных.
         * Если пользователь существует, метод возвращает true, иначе - false.
         */
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param('ss', $this->email, $this->password);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res->num_rows == 1;
    }
}
