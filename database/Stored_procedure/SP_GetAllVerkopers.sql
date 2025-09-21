--Stored procedure haalt alle data op in de database
--zo hoeft er geen query uitgevoerd te hoeven worden op de client side, alleen een call 

--verwijderen procedure als deze bestaat
DROP PROCEDURE IF EXISTS Sp_GetAllVerkopers;

--veranderd einde van een statement tijdelijk naar $$
DELIMITER $$

--maak procedure Sp_GetAllVerkopers
CREATE PROCEDURE Sp_GetAllVerkopers()
BEGIN
    -- select om alle benodigde data van verkopers
    SELECT VKPR.Id
          ,VKPR.Naam
          ,VKPR.SpecialeStatus
          ,VKPR.VerkooptSoort
          ,VKPR.StandType
          ,VKPR.Dagen
          ,VKPR.LogoUrl
    FROM verkopers AS VKPR;
END$$

--zet einde van statement naar standaard
DELIMITER ;