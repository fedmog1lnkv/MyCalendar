CREATE DATABASE my_calendar;

USE my_calendar;

CREATE TABLE users
(
    id         INT(11) NOT NULL AUTO_INCREMENT,     -- уникальный идентификатор пользователя
    email      VARCHAR(255) NOT NULL,               -- E-mail пользователя
    password   VARCHAR(255) NOT NULL,               -- пароль
    PRIMARY KEY (id)
);

CREATE TABLE tasks
(
    id         INT(11) NOT NULL AUTO_INCREMENT,     -- уникальный идентификатор задачи
    user_id    INT(11) NOT NULL,                    -- идентификатор пользователя, которому принадлежит задача
    theme      VARCHAR(255) DEFAULT NULL,           -- тема задачи
    type       VARCHAR(50)  DEFAULT NULL,           -- тип задачи
    location   VARCHAR(255) DEFAULT NULL,           -- место задачи
    start_date DATETIME     DEFAULT NULL,           -- дата начала задачи
    duration   INT(11)      DEFAULT NULL,           -- продолжительность задачи
    comment    TEXT,                                -- комментарий к задаче
    status     VARCHAR(20)  DEFAULT 'in_work',      -- статус задачи
    PRIMARY KEY (id)
);