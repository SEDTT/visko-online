SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--by default we will store the date and time every time the user clicks "submit"
CREATE TABLE User(
	U_id INT NOT NULL AUTO_INCREMENT,
	U_email CHAR(255) NOT NULL,
	U_first CHAR(255),
	U_last CHAR(255),
	U_pwd CHAR(255) NOT NULL,
	U_reg_user BOOLEAN DEFAULT false,
	U_confirmed BOOLEAN DEFAULT false,
	U_reg_date CHAR(255) NOT NULL, 
	U_affiliation CHAR(255) DEFAULT 'N/A',
	PRIMARY KEY(U_id, U_email)
);

CREATE TABLE History(
	U_id INT NOT NULL AUTO_INCREMENT,
	U_email CHAR(255) NOT NULL,
	U_first CHAR(255),
	U_last CHAR(255),
	U_pwd CHAR(255) NOT NULL,
	U_reg_user BOOLEAN DEFAULT false,
	U_confirmed BOOLEAN DEFAULT false,
	U_reg_date CHAR(255) NOT NULL, 
	U_affiliation CHAR(255) DEFAULT 'N/A',
	PRIMARY KEY(U_id, U_email)
);