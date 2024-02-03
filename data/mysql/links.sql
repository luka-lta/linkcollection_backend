CREATE TABLE `links`
(
    `id`       int         NOT NULL,
    `page_id`  int         NOT NULL,
    `owner_id` int         NOT NULL,
    `name`     varchar(50) NOT NULL,
    `url`      text        NOT NULL
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb4
  COLLATE = utf8mb4_0900_ai_ci;

ALTER TABLE `links`
    ADD PRIMARY KEY (`id`);

ALTER TABLE `links`
    MODIFY `id` int NOT NULL AUTO_INCREMENT;
