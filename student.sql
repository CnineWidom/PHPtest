drop table if exists 'student';
create table `student`(
	'stu_id' int(11) not null auto_increament,
	'stu_name' varchar(225) not null comment '学生姓名',
	'stu_sex' char(1) not null default '1' comment'1女 0男',
	'stu_height' int(11) default '170' comment'身高',
	'stu_weight' int(11) default'100' comment'体重',
)

create table if not exists `student_community`(
	`sc_id` int (11)not null auto_increment,
	`sc_name` varchar(255) not null comment'社团名字',
	`sc_create_id` int(255) not null comment'创始人id',
	`sc_create_name` varchar(255) not null comment'创始人',
	`sc_isuse` int(1) not null default 1 comment'是否启用',
	primary key(`sc_id`)
)ENGINE=MyISAM   CHARSET=utf8 COMMENT='社团表';

drop table if exists 'select_community';
create table `select_community`(
	`scy_id` int(11) not null auto_increment comment '选择的id',
	`scy_stu_id` int(11) not null comment'学生的id',
	`scy_stu_name` varchar(225) not null comment '学生姓名',
	`scy_com_id` int (11)not null comment '社团id',
	`scy_com_name` varchar(255) not null comment'社团名字',
	`scy_join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '加入时间' ,
	`scy_join_flag` tinyint(1) default 1 comment'是否有效',
	`scy_join_auto` tinyint(1) default 1 comment'是否自动分配',
	primary key(`scy_id`)
)ENGINE=MyISAM   CHARSET=utf8 COMMENT='加入社团表';

alter table community rename test1; --修改表名 

alter table community add  column name varchar(10); --添加表列 

alter table community drop  column name; --删除表列 

alter table community modify address char(10) --修改表列类型 
||alter table community change address address  char(40) 