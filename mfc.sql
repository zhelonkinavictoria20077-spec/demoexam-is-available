-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Хост: MySQL-5.7
-- Время создания: Окт 16 2025 г., 19:15
-- Версия сервера: 5.7.44
-- Версия PHP: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;

--
-- База данных: `mfc`
--

-- --------------------------------------------------------
--
-- Структура таблицы `appointments`
--

CREATE TABLE `appointments` (
  `id` INT NOT NULL,
  `user_id` INT NOT NULL,
  `service` ENUM(
    'Получить услугу (прием документов)',
    'Выдача результата (выдача готовых документов)',
    'Консультация',
    'Получить услугу ВНЕ ОЧЕРЕДИ (категория граждан, имеющих право на обслуживание вне очереди)',
    'Социальные выплаты семьям с детьми',
    'Сектор пользовательского сопровождения'
  ) NOT NULL,
  `visit_datetime` DATETIME NOT NULL,
  `status` ENUM('ожидает','подтверждена','отменена','завершена') DEFAULT 'ожидает',
  `employee_response` TEXT DEFAULT NULL,
  `review` VARCHAR(500) DEFAULT NULL,
  `responsible_employee` VARCHAR(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `appointments`
--

INSERT INTO `appointments` 
(`id`, `user_id`, `service`, `visit_datetime`, `status`, `employee_response`, `review`, `responsible_employee`)
VALUES
(1, 4, 'Консультация', '2026-09-24 10:00:00', 'подтверждена', 'Приходите в указанное время! Ваш код: 126672. В назначенное время получите талон электронной очереди, используя данный код.', 'Быстрое обслуживание', 'Сотрудник 1 Макарова Анна Васильевна');

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` INT NOT NULL,
  `fullname` VARCHAR(255) NOT NULL,
  `passport_data` VARCHAR(100) NOT NULL COMMENT 'Серия, номер, дата выдачи паспорта',
  `phone` VARCHAR(20) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `login` VARCHAR(100) NOT NULL UNIQUE,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('user','admin','employee') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` 
(`id`, `fullname`, `passport_data`, `phone`, `email`, `login`, `password`, `role`) 
VALUES
(1, 'Админ', '2365 456321 10.08.2000', '+7900-500-50-50', 'Admin588@mail.ru', 'admin', 'admin123', 'admin'),
(2, 'Сотрудник 1 Макарова Анна Васильевна', '1223 123456 01.03.2000', '+7900-123-12-51', 'SOTRUDNIK.MFC1@mail.ru', 'sotrudnik1', 'sotrudnik123', 'employee'),
(3, 'Сотрудник 2 Кузнецова Татьяна Викторовна', '2345 987654 20.10.2000', '+7965-222-21-22', 'SOTRUDNIK.MFC2@mail.ru', 'sotrudnik2', 'sotrudnik223', 'employee'),
(4, 'Подтянутый Павел Сергеевич', '4567 456302 12.07.2002', '+7800-899-99-99', 'pavel@mail.ru', 'pavel', 'pavel123456', 'user');

--
-- Индексы таблиц
--

ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY (`login`);

--
-- AUTO_INCREMENT для таблиц
--

ALTER TABLE `appointments`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

ALTER TABLE `users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Внешние ключи
--

ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` 
  FOREIGN KEY (`user_id`) 
  REFERENCES `users` (`id`) 
  ON DELETE CASCADE;

COMMIT;