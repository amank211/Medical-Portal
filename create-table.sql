CREATE TABLE IF NOT EXISTS btech_students(
	student_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	prim_email VARCHAR(50) NOT NULL UNIQUE,
	sec_email VARCHAR(50) UNIQUE,
	DOB DATE NOT NULL,
	blood_group VARCHAR(20),
	hostel_wing VARCHAR(5) NOT NULL,
	room_no INT NOT NULL,
	batch INT NOT NULL,
	department VARCHAR(50) NOT NULL,
	perm_address VARCHAR(300),
	mobile_prim VARCHAR(15) NOT NULL UNIQUE,
	mobile_sec VARCHAR(15) UNIQUE

	
);
CREATE TABLE IF NOT EXISTS mtech_students(
	student_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	prim_email VARCHAR(50) NOT NULL UNIQUE,
	sec_email VARCHAR(50) UNIQUE,
	DOB DATE NOT NULL,
	blood_group VARCHAR(20),
	hostel_wing VARCHAR(5) NOT NULL,
	room_no INT NOT NULL,
	batch INT NOT NULL,
	branch VARCHAR(50) NOT NULL,
	perm_address VARCHAR(300),
	mobile_prim VARCHAR(15) NOT NULL UNIQUE,
	mobile_sec VARCHAR(15) UNIQUE
);
CREATE TABLE IF NOT EXISTS phd_students(
	student_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	prim_email VARCHAR(50) NOT NULL UNIQUE,
	sec_email VARCHAR(50) UNIQUE,
	DOB DATE NOT NULL,
	blood_group VARCHAR(20),
	hostel_wing VARCHAR(5) NOT NULL,
	room_no INT NOT NULL,
	batch INT NOT NULL,
	branch VARCHAR(50) NOT NULL,
	perm_address VARCHAR(300),
	mobile_prim VARCHAR(15) NOT NULL UNIQUE,
	mobile_sec VARCHAR(15) UNIQUE
);
CREATE TABLE IF NOT EXISTS faculty(
	faculty_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	prim_email VARCHAR(50) NOT NULL UNIQUE,
	sec_email VARCHAR(50) UNIQUE,
	DOB DATE NOT NULL,
	blood_group VARCHAR(20),
	departament VARCHAR(50) NOT NULL,
	office_address VARCHAR(100),
	perm_address VARCHAR(300),
	mobile_prim VARCHAR(15) NOT NULL UNIQUE,
	mobile_sec VARCHAR(15) UNIQUE
);
CREATE TABLE IF NOT EXISTS staff(
	staff_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	prim_email VARCHAR(50) NOT NULL UNIQUE,
	sec_email VARCHAR(50) UNIQUE,
	DOB DATE NOT NULL,
	blood_group VARCHAR(20),
	department VARCHAR(50) NOT NULL,
	office_address VARCHAR(100),
	perm_address VARCHAR(300),
	mobile_prim VARCHAR(15) NOT NULL UNIQUE,
	mobile_sec VARCHAR(15) UNIQUE
);
CREATE TABLE IF NOT EXISTS Doctors(
	doctor_id INT NOT NULL PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	password VARCHAR(100) NOT NULL,
	specilisation VARCHAR(50),
	prim_email VARCHAR(50) NOT NULL UNIQUE,
	sec_email VARCHAR(50) UNIQUE,
	mob_prim VARCHAR(15) NOT NULL UNIQUE,
	mob_sec VARCHAR(15) UNIQUE

);
