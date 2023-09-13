CREATE TABLE user(
	id INT AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY(id)
);
CREATE TABLE article(
	id INT AUTO_INCREMENT,
	title VARCHAR(255) NOT NULL,
	description TEXT,
	PRIMARY KEY(id)
);

INSERT INTO user (username, password) VALUES ('admin', '$2y$10$j.G28MOHKDqjHyNIcBS8..oNqcEH8s9kQB/mAOJLUMhV.rwtbNcda');