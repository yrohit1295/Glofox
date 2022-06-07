Create database studio;
create table classes (id int not null AUTO_INCREMENT, class_name varchar(255), class_date date, capacity int, primary key(id));
create table bookings (booking_id int NOT NULL AUTO_INCREMENT, class_id int not null, name varchar(255), booking_date Date, PRIMARY KEY (booking_id), FOREIGN KEY (class_id) REFERENCES classes(id));
