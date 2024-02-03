CREATE TABLE `user_roles`
(
    `id`      int NOT NULL,
    `user_id` int NOT NULL,
    `role_id` int NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE `user_roles`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `user_roles`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
