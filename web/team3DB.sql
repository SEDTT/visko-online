SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

--by default we will store the date and time every time the user clicks "submit"
CREATE TABLE IF NOT EXISTS User(
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

CREATE TABLE IF NOT EXISTS History(
	U_id INT NOT NULL AUTO_INCREMENT,
	H_id INT NOT NULL,
	H_Query VARCHAR(255),
	H_date VARCHAR(255),
	PRIMARY KEY(U_id, H_id)
);

CREATE TABLE IF NOT EXISTS Service(
	U_id INT NOT NULL AUTO_INCREMENT,
	S_id INT NOT NULL,
	S_registered CHAR(255),
	S_date CHAR(255) NOT NULL,
	PRIMARY KEY(U_id, S_id)
);

CREATE TABLE IF NOT EXISTS QueryError(
	Qe_id INT NOT NULL AUTO_INCREMENT,
	E_id INT NOT NULL,
	E_type VARCHAR(255) NOT NULL,
	Q_msg VARCHAR(255) NOT NULL,
	PRIMARY KEY(Qe_id, E_id)
);

CREATE TABLE IF NOT EXISTS PipelineError(
	Pe_id INT NOT NULL AUTO_INCREMENT,
	E_id INT NOT NULL,
	E_type VARCHAR(255) NOT NULL,
	P_id INT NOT NULL,
	P_msg VARCHAR(255) NOT NULL,
	PRIMARY KEY(Pe_id, E_id)
);

CREATE TABLE IF NOT EXISTS ServiceError(
	Se_id INT NOT NULL AUTO_INCREMENT,
	E_id INT NOT NULL,
	E_type VARCHAR(255) NOT NULL,
	S_id INT NOT NULL,
	S_msg VARCHAR(255) NOT NULL,
	PRIMARY KEY(Se_id, E_id)
);