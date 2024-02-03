CREATE TABLE `roles`
(
    `id`   int          NOT NULL,
    `name` varchar(100) NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE `roles`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `roles`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;