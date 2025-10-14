DROP PROCEDURE IF EXISTS sp_CreateVerkoper;
-- voeg commentaar toe

DELIMITER $$

CREATE PROCEDURE sp_CreateVerkoper(
    IN v_name VARCHAR(200),
    IN v_speciale_status VARCHAR(10),
    IN v_verkoopt_soort VARCHAR(20),
    IN v_stand_type VARCHAR(10),
    IN v_dagen VARCHAR(10),
    IN v_logo_url VARCHAR(500),
    IN v_is_actief BOOLEAN,
    IN v_opmerking TEXT
)
BEGIN
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

    SELECT LAST_INSERT_ID() AS new_id;
END$$

DELIMITER ;