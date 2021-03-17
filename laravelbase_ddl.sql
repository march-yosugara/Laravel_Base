-- Drop table
-- DROP TABLE failed_jobs;
CREATE TABLE failed_jobs (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  connection text CHARACTER SET utf8 NOT NULL,
  queue text CHARACTER SET utf8 NOT NULL,
  payload text CHARACTER SET utf8 NOT NULL,
  exception text CHARACTER SET utf8 NOT NULL,
  failed_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY id (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Drop table
-- DROP TABLE groups;
CREATE TABLE groups (
  group_id varchar(5) COLLATE utf8_bin NOT NULL,
  group_name varchar(100) COLLATE utf8_bin NOT NULL,
  group_pass varchar(255) COLLATE utf8_bin NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (group_id),
  UNIQUE KEY groups_un (group_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Drop table
-- DROP TABLE password_resets;
CREATE TABLE password_resets (
  email varchar(255) COLLATE utf8_bin NOT NULL,
  token varchar(255) COLLATE utf8_bin NOT NULL,
  created_at timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin

-- Drop table
-- DROP TABLE users;
CREATE TABLE users (
  id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  name varchar(255) COLLATE utf8_bin NOT NULL,
  email varchar(255) COLLATE utf8_bin NOT NULL,
  email_verified_at timestamp NULL DEFAULT NULL,
  password varchar(255) COLLATE utf8_bin NOT NULL,
  remember_token varchar(100) COLLATE utf8_bin DEFAULT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id (id),
  UNIQUE KEY users_email_unique (email)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Drop table
-- DROP TABLE notes;
CREATE TABLE notes (
  group_id varchar(5) COLLATE utf8_bin NOT NULL,
  note_id int(11) NOT NULL,
  note_name varchar(100) COLLATE utf8_bin NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (group_id,note_id),
  CONSTRAINT notes_ibfk_1 FOREIGN KEY (group_id) REFERENCES groups (group_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Drop table
-- DROP TABLE users_groups;
CREATE TABLE users_groups (
  users_groups_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  user_id bigint(20) unsigned NOT NULL,
  group_id varchar(5) COLLATE utf8_bin NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (users_groups_id),
  UNIQUE KEY users_groups_id (users_groups_id),
  KEY users_groups_fk (user_id),
  KEY users_groups_fk_1 (group_id),
  CONSTRAINT users_groups_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT users_groups_ibfk_2 FOREIGN KEY (group_id) REFERENCES groups (group_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- Drop table
-- DROP TABLE note_items;
CREATE TABLE note_items (
  group_id varchar(5) COLLATE utf8_bin NOT NULL,
  note_id int(11) NOT NULL,
  note_item_id int(11) NOT NULL,
  note_item_title varchar(100) COLLATE utf8_bin DEFAULT NULL,
  str1 varchar(50) COLLATE utf8_bin DEFAULT NULL,
  str2 varchar(50) COLLATE utf8_bin DEFAULT NULL,
  int_val1 int(11) DEFAULT NULL,
  int_val2 int(11) DEFAULT NULL,
  unit1 varchar(10) COLLATE utf8_bin DEFAULT NULL,
  unit2 varchar(10) COLLATE utf8_bin DEFAULT NULL,
  memo text COLLATE utf8_bin,
  created_at timestamp NULL DEFAULT NULL,
  updated_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (group_id,note_id,note_item_id),
  CONSTRAINT note_items_ibfk_1 FOREIGN KEY (group_id, note_id) REFERENCES notes (group_id, note_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
