CREATE TABLE Utilisateur (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
pseudo VARCHAR(30) NOT NULL,
pass VARCHAR(256) NOT NULL,
date_ajout TIMESTAMP
) 

INSERT INTO Utilisateur (pseudo,motdepasse,dateajout)
VALUES ("test","$1$ATcPJ.g6$0xCaaYe19OPLXKBYmlWsY/",SYSDATE());

