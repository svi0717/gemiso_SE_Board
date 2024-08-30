CREATE TABLE gemiso_se.board (
	board_id numeric NOT NULL,
	title varchar(30) NOT NULL,
	user_id varchar(30) NOT NULL,
	"content" varchar NOT NULL,,
	reg_date date NULL,
	upd_date date NULL,
	delete_yn bpchar(1) NULL,
	deleted_at date NULL,
	"views" numeric NULL,
	CONSTRAINT board_pk PRIMARY KEY (board_id)
    CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES gemiso_se."user"(user_id)
);

CREATE TABLE gemiso_se.schedule (
	sch_id numeric NOT NULL,
	board_id numeric NULL,
	reg_date date NULL,
	start_date date NULL,
	end_date date NULL,
	delete_yn bpchar(1) NULL,
	deleted_at date NULL,
	user_id  varchar(30) NOT NULL,
	CONSTRAINT schedule_pk PRIMARY KEY (sch_id)
	CONSTRAINT user_fk FOREIGN KEY (user_id) REFERENCES gemiso_se."user"(user_id)
);

CREATE TABLE gemiso_se.user (
	id SERIAL,
	user_id varchar(30) NOT NULL,
	"password" varchar(100) NOT NULL,
	"name" varchar(20) NOT NULL,
	phone varchar(12) NOT NULL,
	department varchar(20) NULL,
	reg_date date NULL,
	upd_date date NULL,
	delete_yn bpchar(1) DEFAULT 'N'::bpchar NULL,
	deleted_at date NULL,
	CONSTRAINT user_pk PRIMARY KEY (user_id)
);
