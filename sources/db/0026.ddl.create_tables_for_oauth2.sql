CREATE TABLE IF NOT EXISTS `access_tokens` (
  `oauth_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`oauth_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `auth_codes` (
  `code` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `redirect_uri` varchar(200) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `clients` (
  `client_id` char(20) NOT NULL,
  `client_secret` char(40) NOT NULL,
  `redirect_uri` varchar(255) NOT NULL,
  `user_id` char(36) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` char(36) NOT NULL,
  `user_id` char(36) NOT NULL,
  `expires` int(11) NOT NULL,
  `scope` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;