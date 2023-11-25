create database user;

use user;

create table user.form (
    -> id int auto_increment not null primary key,
    -> username VARCHAR(100),
    -> password VARCHAR(100)
    -> );