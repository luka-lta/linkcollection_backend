CREATE TABLE `users`
(
    `id`       int          NOT NULL,
    `username` varchar(200) NOT NULL,
    `email`    varchar(200) NOT NULL,
    `password` text         NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE `users`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `users`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
