DROP DATABASE IF EXISTS laravel;
CREATE DATABASE laravel;

CREATE TABLE `Organisator` (
  `Id` int PRIMARY KEY,
  `Naam` varchar(255),
  `Gebruikersnaam` varchar(255),
  `Wachtwoord` varchar(255),
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime
) ENGINE=InnoDB;

CREATE TABLE `Bezoeker` (
  `Id` int PRIMARY KEY,
  `Naam` varchar(255),
  `Email` varchar(255),
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime
) ENGINE=InnoDB;

CREATE TABLE `Evenement` (
  `Id` int PRIMARY KEY,
  `Naam` varchar(255),
  `Datum` date,
  `Locatie` varchar(255),
  `AantalTicketsPerTijdslot` int,
  `BeschikbareStands` int,
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime
) ENGINE=InnoDB;

CREATE TABLE `Prijs` (
  `Id` int PRIMARY KEY,
  `EvenementId` int,
  `Datum` date,
  `Tijdslot` varchar(255),
  `Tarief` decimal,
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime,
  FOREIGN KEY (`EvenementId`) REFERENCES `Evenement` (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Ticket` (
  `Id` int PRIMARY KEY,
  `BezoekerId` int,
  `EvenementId` int,
  `PrijsId` int,
  `AantalTickets` int,
  `Datum` datetime,
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime,
  FOREIGN KEY (`BezoekerId`) REFERENCES `Bezoeker` (`Id`),
  FOREIGN KEY (`EvenementId`) REFERENCES `Evenement` (`Id`),
  FOREIGN KEY (`PrijsId`) REFERENCES `Prijs` (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Verkoper` (
  `Id` int PRIMARY KEY,
  `Naam` varchar(255),
  `SpecialeStatus` boolean,
  `VerkooptSoort` varchar(255),
  `StandType` varchar(255),
  `Dagen` varchar(255),
  `Logo` varchar(255),
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime
) ENGINE=InnoDB;

CREATE TABLE `Stand` (
  `Id` int PRIMARY KEY,
  `VerkoperId` int,
  `StandType` varchar(255),
  `Prijs` decimal,
  `VerhuurdStatus` boolean,
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime,
  FOREIGN KEY (`VerkoperId`) REFERENCES `Verkoper` (`Id`)
) ENGINE=InnoDB;

CREATE TABLE `Contactpersoon` (
  `Id` int PRIMARY KEY,
  `Naam` varchar(255),
  `Telefoonnummer` varchar(255),
  `Email` varchar(255),
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime
) ENGINE=InnoDB;

CREATE TABLE `ContactPerVerkoper` (
  `Id` int PRIMARY KEY,
  `VerkoperId` int,
  `ContactpersoonId` int,
  `Isactief` boolean,
  `Opmerking` text,
  `Datumaangemaakt` datetime,
  `Datumgewijzigd` datetime,
  FOREIGN KEY (`VerkoperId`) REFERENCES `Verkoper` (`Id`),
  FOREIGN KEY (`ContactpersoonId`) REFERENCES `Contactpersoon` (`Id`)
) ENGINE=InnoDB;
