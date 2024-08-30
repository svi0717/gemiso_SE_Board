CREATE TABLE "gemiso_SE".board (
	board_id numeric NOT NULL,
	title varchar NOT NULL,
	writer varchar NOT NULL,
	"content" varchar NOT NULL,
	reg_date date NULL,
	upd_date date NULL,
	delete_yn bpchar NULL,
	deleted_at date NULL,
	"views" int4 NULL,
	CONSTRAINT board_pk PRIMARY KEY (board_id)
);

CREATE TABLE "gemiso_SE".schedule (
	sch_id numeric NOT NULL,
	board_id numeric NULL,
	reg_date date NULL,
	start_date date NULL,
	end_date date NULL,
	delete_yn bpchar NULL,
	deleted_at date NULL,
	user_id varchar NULL,
	CONSTRAINT schedule_pk PRIMARY KEY (sch_id)
);

CREATE TABLE "gemiso_SE"."user" (
	user_id numeric NOT NULL,
	id varchar NOT NULL,
	"password" varchar NOT NULL,
	"name" varchar NOT NULL,
	phone varchar NOT NULL,
	department varchar NULL,
	reg_date date NULL,
	upd_date date NULL,
	delete_yn bpchar NULL,
	deleted_at date NULL,
	CONSTRAINT users_pk PRIMARY KEY (user_id)
);