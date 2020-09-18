-- failed_jobs definition

-- Drop table

-- DROP TABLE failed_jobs;

CREATE TABLE failed_jobs (
	id serial NOT NULL,
	connection text NOT NULL,
	queue text NOT NULL,
	payload text NOT NULL,
	exception text NOT NULL,
	failed_at timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
	CONSTRAINT failed_jobs_pkey PRIMARY KEY (id)
);

-- groups definition

-- Drop table

-- DROP TABLE groups;

CREATE TABLE groups (
	group_id varchar(5) NOT NULL, -- ID数字5桁
	group_name varchar(100) NOT NULL, -- グループ名
	group_pass varchar(255) NOT NULL, -- グループパスワード
	created_at timestamp NULL,
	updated_at timestamp NULL,
	CONSTRAINT groups_pk PRIMARY KEY (group_id)
);

-- password_resets definition

-- Drop table

-- DROP TABLE password_resets;

CREATE TABLE password_resets (
	email varchar(255) NOT NULL,
	token varchar(255) NOT NULL,
	created_at timestamp NULL
);

-- users definition

-- Drop table

-- DROP TABLE users;

CREATE TABLE users (
	id serial NOT NULL,
	name varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	email_verified_at timestamp NULL,
	password varchar(255) NOT NULL,
	remember_token varchar(100) NULL,
	created_at timestamp NULL,
	updated_at timestamp NULL,
	CONSTRAINT users_email_unique UNIQUE (email),
	CONSTRAINT users_pkey PRIMARY KEY (id)
);

-- notes definition

-- Drop table

-- DROP TABLE notes;

CREATE TABLE notes (
	group_id varchar(5) NOT NULL, -- ノートグループID
	note_id int NOT NULL, -- ノートID
	note_name varchar(100) NOT NULL, -- ノート名
	created_at timestamp NULL,
	updated_at timestamp NULL,
	CONSTRAINT notes_pk PRIMARY KEY (group_id, note_id),
	CONSTRAINT notes_fk FOREIGN KEY (group_id) REFERENCES groups(group_id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- users_groups definition

-- Drop table

-- DROP TABLE users_groups;

CREATE TABLE users_groups (
	users_groups_id serial NOT NULL, -- ユーザーグループ関連ID
	user_id bigint(20) unsigned NOT NULL, -- 関連ユーザID
	group_id varchar(5) NOT NULL, -- 関連グループID
	created_at timestamp NULL,
	updated_at timestamp NULL,
	CONSTRAINT users_groups_pk PRIMARY KEY (users_groups_id),
	CONSTRAINT users_groups_fk FOREIGN KEY (user_id) REFERENCES users(id) ON UPDATE CASCADE ON DELETE CASCADE,
	CONSTRAINT users_groups_fk_1 FOREIGN KEY (group_id) REFERENCES groups(group_id) ON UPDATE CASCADE ON DELETE CASCADE
);

-- note_items definition

-- Drop table

-- DROP TABLE note_items;

CREATE TABLE note_items (
	group_id varchar(5) NOT NULL, -- 関連グループID
	note_id int NOT NULL, -- 汎用ノートID
	note_item_id int NOT NULL, -- 汎用ノート項目ID
	note_item_title varchar(100) NULL, -- 汎用ノート項目タイトル
	str1 varchar(50) NULL, -- 文字列項目1
	str2 varchar(50) NULL, -- 文字列項目2
	int_val1 int NULL, -- 数値項目1
	int_val2 int NULL, -- 数値項目2
	unit1 varchar(10) NULL, -- 単位項目1
	unit2 varchar(10) NULL, -- 単位項目2
	memo text NULL, -- メモ項目
	created_at timestamp NULL,
	updated_at timestamp NULL,
	CONSTRAINT note_items_pk PRIMARY KEY (group_id, note_id, note_item_id),
	CONSTRAINT note_items_fk FOREIGN KEY (group_id, note_id) REFERENCES notes(group_id, note_id) ON UPDATE CASCADE ON DELETE CASCADE
);
