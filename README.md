Stackoverflowinspirerat kommentarssystem
=========

####Installera

Du kan installera din egna version genom att klona
följande länk https://github.com/tija14/projektPHPMVC
eller ladda ned ned via länken
https://github.com/tija14/projektPHPMVC/archive/master.zip


####Databaser

Det behövs följande databaser för projektet:
-Frågor
-Svar
-Kommentarer
-Kommentarer för svar
-Taggar
-Användare

Sedan behövs även en databas som kopplar samman frågorna med taggarna.
Koden för den databasen är följande:

CREATE TABLE comment2tag
(
  idComment INT NOT NULL,
  idTag INT NOT NULL,
 
  FOREIGN KEY (idComment) REFERENCES comment (id),
  FOREIGN KEY (idTag) REFERENCES tags (id),
 
  PRIMARY KEY (idComment, idTag)
) ENGINE INNODB;