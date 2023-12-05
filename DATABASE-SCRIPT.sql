create database db_agenda;
use db_agenda;

create table tb_usuarios(
cd_usuario int primary key auto_increment,
nm_usuario varchar(30) not null unique,
cd_senha mediumtext not null
)engine=InnoDB default charset=utf8mb4;

create table tb_tarefas(
cd_tarefa int primary key auto_increment,
nm_tarefa varchar(30) not null,
ds_tarefa longtext not null,
dt_registro date not null default current_timestamp,
dt_prazo date not null,
st_tarefa char(1) not null,
dt_termino date,
id_usuario int not null,
foreign key (id_usuario) references tb_usuarios(cd_usuario)
)engine=InnoDB default charset=utf8mb4;
