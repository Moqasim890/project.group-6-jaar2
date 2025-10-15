-- verwijdert de procedure als deze al bestaat
DROP PROCEDURE IF EXISTS sp_GetVerkoperByNaam;

-- wijzigt de delimiter zodat er meer dan een statements kunnen in de procedure
DELIMITER $$

-- maakt een nieuwe stored procedure
CREATE PROCEDURE sp_GetVerkoperByNaam(
    -- input parameter
    IN v_naam VARCHAR(200)
)
BEGIN
    -- select
    SELECT 
        -- kolom "Naam"
        VKPR.Naam
    -- van verkopers afgekort naar VKPR
    FROM verkopers AS VKPR
    -- waar kolom "Naam" Gelijk is aan input naam
    -- utf8mb4_unicode_ci zorgt ervoor dat het niet uitmaakt of het hoofdletters of kleine leters zijn
    -- dus "TEST" = "test" is TRUE
    WHERE VKPR.Naam COLLATE utf8mb4_unicode_ci = v_naam COLLATE utf8mb4_unicode_ci;
END$$

-- Zet de delimiter weer terug naar de standaard puntkomma
DELIMITER ;
