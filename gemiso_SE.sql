CREATE TABLE gemiso_se.board (
	board_id serial4 NOT NULL,
	title varchar(30) NOT NULL,
	user_id varchar(30) NOT NULL,
	"content" varchar NOT NULL,
	reg_date timestamp NULL,
	upd_date timestamp NULL,
	delete_yn bpchar(1) NULL,
	deleted_at date NULL,
	"views" numeric NULL,
	CONSTRAINT board_pk PRIMARY KEY (board_id),
	CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES gemiso_se.users(user_id)
);

CREATE TABLE gemiso_se.schedule (
    sch_id serial4 NOT NULL,
    board_id numeric NULL,
    title varchar(30) NOT NULL,
    "content" varchar NOT NULL,
    reg_date date NULL,
    start_date date NULL,
    end_date date NULL,
    delete_yn bpchar(1) NULL,
    deleted_at date NULL,
    user_id varchar(30) NOT NULL,
    CONSTRAINT schedule_pk PRIMARY KEY (sch_id),
    CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES gemiso_se."users"(user_id)
);

CREATE TABLE gemiso_se."comments" (
	c_id serial4 NOT NULL,
	user_id varchar(30) NULL,
	board_id int4 NULL,
	parent_id int4 NULL,
	"content" text NULL,
	reg_date timestamp NULL,
	upd_date timestamp NULL,
	delete_yn bpchar(1) NOT NULL,
	deleted_at date NULL,
	CONSTRAINT comment_pk PRIMARY KEY (c_id),
	CONSTRAINT board_fk FOREIGN KEY (board_id) REFERENCES gemiso_se.board(board_id),
	CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES gemiso_se."users"(user_id)
);

CREATE TABLE gemiso_se.files (
	id serial4 NOT NULL,
	file_name varchar(255) NOT NULL,
	file_path text NOT NULL,
	file_size int4 NULL,
	file_type varchar(50) NOT NULL,
	upload_date timestamp DEFAULT CURRENT_TIMESTAMP NULL,
	board_id int4 NULL,
	delete_yn bpchar(1) NULL,
	deleted_at date NULL,
	CONSTRAINT files_pkey PRIMARY KEY (id),
	CONSTRAINT files_board_id_fkey FOREIGN KEY (board_id) REFERENCES gemiso_se.board(board_id) ON DELETE CASCADE
);

CREATE TABLE gemiso_se.users (
	id serial4 NOT NULL,
	user_id varchar(255) NOT NULL,
	"password" varchar(255) NOT NULL,
	"name" varchar(255) NOT NULL,
	phone varchar(255) NOT NULL,
	department varchar(255) NULL,
	reg_date date NULL,
	upd_date date NULL,
	delete_yn bpchar(1) DEFAULT 'N'::bpchar NULL,
	deleted_at date NULL,
	CONSTRAINT gemiso_se_users_user_id_unique UNIQUE (user_id),
	CONSTRAINT users_pkey PRIMARY KEY (id)
);
