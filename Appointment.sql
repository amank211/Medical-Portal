CREATE TABLE Appointments(
	appno INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(50) NOT NULL UNIQUE,
	problem VARCHAR(50) NOT NULL UNIQUE,
	booked_at DATETIME DEFAULT CURRENT_TIMESTAMP,
	Doctor VARCHAR(50) NOT NULL UNIQUE,
	appointtime DATETIME 

);