-- verwijdert de procedure als deze al bestaat
DROP PROCEDURE IF EXISTS sp_CreateVerkoper;

-- wijzigt de delimiter zodat er meer dan een statements kunnen in de procedure
DELIMITER $$

CREATE PROCEDURE sp_CreateVerkoper(
    -- input parameters
    IN v_name VARCHAR(200),
    IN v_speciale_status VARCHAR(10),
    IN v_verkoopt_soort VARCHAR(20),
    IN v_stand_type VARCHAR(10),
    IN v_dagen VARCHAR(10),
    IN v_logo_url VARCHAR(500),
    IN v_is_actief BIT,
    IN v_opmerking TEXT
)
BEGIN
    -- insert in verkopers
    INSERT INTO verkopers (
        Naam,
        SpecialeStatus,
        VerkooptSoort,
        StandType,
        Dagen,
        LogoUrl,
        IsActief,
        Opmerking
    )
    -- met waarden van input parameters
    VALUES (
        v_name,
        v_speciale_status,
        v_verkoopt_soort,
        v_stand_type,
        v_dagen,
        v_logo_url,
        v_is_actief,
        v_opmerking
    );
END$$

DELIMITER ;
