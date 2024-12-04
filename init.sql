CREATE Database adatbazis;
use adatbazis;
create table varos(
ID int auto_increment,
Lakossag int,
neve varchar(255),
primary key(ID));
create table bejegyzes(
varos_ID int,
datum date,
homerseklet int,
ID int auto_increment,
primary key (ID),
foreign key (varos_ID) references varos(ID)
);
insert into varos (Lakossag, neve) values 
('8.9', 'Parizs'),
('2', 'London'),
('9', 'Washington');
insert into bejegyzes (varos_ID, datum,homerseklet) values 
('1', '2024-02-03','4'),
('2', '2024-07-10','34'),
('1', '2024-12-08','-4'),
('2', '2024-05-04','24'),
('1', '2024-09-03','20');
