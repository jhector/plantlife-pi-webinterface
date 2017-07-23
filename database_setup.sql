-- Create our database
CREATE DATABASE IF NOT EXISTS plantlife;

-- Create a database user
CREATE USER 'user'@'localhost' IDENTIFIED BY 'user';

-- Grant the user access to the desired database
GRANT ALL ON `plantlife`.* TO 'user'@'localhost' IDENTIFIED BY 'user';

-- Create table for storing user infos
CREATE TABLE IF NOT EXISTS plantlife.user (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	userid INT,
	name VARCHAR(128),
	password VARCHAR(128),
	admin INT
);

-- Create table that contains all available sensor types
CREATE TABLE IF NOT EXISTS plantlife.sensortype (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(128)
);

-- Create table for storing the sensor data
CREATE TABLE IF NOT EXISTS plantlife.sensordata (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	typeid INT,
	value FLOAT,
	date DATETIME,
	FOREIGN KEY (typeid) REFERENCES sensortype(id)
);

-- Create default admin user admin:admin (sha256("admin"))
INSERT INTO plantlife.user(userid, name, password, admin) VALUES
(1, 'admin', '8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918', 1);

-- Fill the sensortype table
INSERT INTO plantlife.sensortype(name) VALUES
('moisture'),
('humidity'),
('temperature'),
('light');
