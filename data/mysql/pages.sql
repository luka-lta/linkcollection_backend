CREATE TABLE `pages`
(
    `id`       int                   NOT NULL,
    `owner_id` int                   NOT NULL,
    `title`    varchar(50)           NOT NULL,
    `theme`    enum ('dark','white') NOT NULL DEFAULT 'dark'
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE `pages`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `pages`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
