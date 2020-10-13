Create table appointments(
	reff_no INT Primary key NOT NULL AUTO_INCREMENT,
	student_id INT NOT NULL,
	Department INT NOT NULL,
	patient_name VarChar(60) NOT null,
	Problem TEXT NOT NULL,
	Doctor_id INT NOT NULL,
	Appoint_time DATETIME NOT NULL,
	BOOKED_AT DATETIME
	
);