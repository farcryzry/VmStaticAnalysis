DROP DATABASE IF EXISTS cmpe283;
CREATE DATABASE cmpe283 ;
USE cmpe283;

GRANT ALL PRIVILEGES ON cmpe283.* 
TO 'group3'@'localhost'
IDENTIFIED BY 'sjsugroup3';


DROP TABLE IF EXISTS cpu;
CREATE TABLE cpu (
  id int NOT NULL AUTO_INCREMENT,
  ip varchar(20) NOT NULL,
  time varchar(50) NOT NULL,
  percent decimal(5,2) NOT NULL, -- % of all CPU 
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS memory;
CREATE TABLE memory (
  id int NOT NULL AUTO_INCREMENT,
  ip varchar(20) NOT NULL,
  time varchar(50) NOT NULL,
  free int, -- kb free memory
  used int, -- kb used memory  
  rate decimal(5,2), -- % of Memory
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS io;
CREATE TABLE io (
  id int NOT NULL AUTO_INCREMENT,
  ip varchar(20) NOT NULL,
  time varchar(50) NOT NULL,
  tps decimal(5,2), -- number of transfer per second
  readps int, -- kb read
  writeps int, -- kb write
  PRIMARY KEY (id)
);

DROP TABLE IF EXISTS thread;
CREATE TABLE thread (
  id int NOT NULL AUTO_INCREMENT,
  ip varchar(20) NOT NULL,
  time varchar(50) NOT NULL,
  total int, -- number of threads
  PRIMARY KEY (id)
);




