SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

CREATE TABLE `ci_sessions` (
                             `id` varchar(128) NOT NULL,
                             `ip_address` varchar(45) NOT NULL,
                             `timestamp` int(10) UNSIGNED NOT NULL DEFAULT '0',
                             `data` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `color` (
                       `id` tinyint(3) UNSIGNED NOT NULL,
                       `name` varchar(31) NOT NULL,
                       `german` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `feedback` (
                          `id` int(10) UNSIGNED NOT NULL,
                          `route` int(10) UNSIGNED NOT NULL,
                          `author_id` varchar(32) NOT NULL,
                          `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                          `questions` smallint(6) NOT NULL,
                          `total` smallint(6) NOT NULL,
                          `data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `formelements` (
                              `id` int(10) UNSIGNED NOT NULL,
                              `type` varchar(31) NOT NULL,
                              `data` text NOT NULL,
                              `index` smallint(5) UNSIGNED NOT NULL,
                              `version` smallint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `images` (
                        `id` int(10) UNSIGNED NOT NULL,
                        `data` mediumblob NOT NULL,
                        `mime` varchar(31) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `routes` (
                        `id` int(10) UNSIGNED NOT NULL,
                        `name` varchar(127) NOT NULL,
                        `grade` varchar(5) NOT NULL,
                        `color` tinyint(3) UNSIGNED NOT NULL,
                        `setter` int(10) UNSIGNED NOT NULL,
                        `wall` tinyint(4) NOT NULL,
                        `image` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `setter` (
                        `id` int(10) UNSIGNED NOT NULL,
                        `name` varchar(127) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `user` (
                      `id` int(10) UNSIGNED NOT NULL,
                      `name` varchar(32) NOT NULL,
                      `password` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

INSERT INTO `user` (`id`, `name`, `password`) VALUES
(1, 'admin', '$6$rounds=1024$qcd6GGGDG8MfiWWy$p5PQ8T0d7BNXqwDd9CeTKPoVHZv8FrUEnFefHfnw2Hqb0kqs7SKaud6tNGRqxFlwypiWjnXGRCi8wlrZT2mfV/');


ALTER TABLE `ci_sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ci_sessions_timestamp` (`timestamp`);

ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uk_route_author` (`route`,`author_id`);

ALTER TABLE `formelements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `index` (`index`);

ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `routes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`),
  ADD KEY `fk_routes_color` (`color`),
  ADD KEY `fk_routes_setter` (`setter`),
  ADD KEY `fk_routes_images` (`image`);

ALTER TABLE `setter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);


ALTER TABLE `color`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
ALTER TABLE `feedback`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
ALTER TABLE `formelements`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
ALTER TABLE `images`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
ALTER TABLE `routes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
ALTER TABLE `setter`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
ALTER TABLE `user`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `routes`
  ADD CONSTRAINT `fk_routes_color` FOREIGN KEY (`color`) REFERENCES `color` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_routes_images` FOREIGN KEY (`image`) REFERENCES `images` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_routes_setter` FOREIGN KEY (`setter`) REFERENCES `setter` (`id`) ON UPDATE CASCADE;

INSERT INTO `color` (`id`, `name`, `german`) VALUES
(1, 'yellow', 'Gelb'),
(2, 'red', 'Rot'),
(3, 'blue', 'Blau'),
(4, 'white', 'Weiß'),
(5, 'green', 'Grün'),
(6, 'turqoise', 'Türkis'),
(7, 'black', 'Schwarz'),
(8, 'grey', 'Grau'),
(9, 'purple', 'Lila'),
(10, 'orange', 'Orange'),
(11, 'pink', 'Pink'),
(12, 'ochre', 'Ocker'),
(13, 'skin', 'Hautfarben'),
(14, 'light-green', 'Hellgrün'),
(15, 'yellow-flecked', 'Gelb meliert'),
(16, 'green-flecked', 'Grün meliert');
