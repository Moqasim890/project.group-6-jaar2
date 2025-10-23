
USE laravel;

DELIMITER $$

DROP PROCEDURE IF EXISTS SP_GetAllEvents $$
DROP PROCEDURE IF EXISTS SP_GetAllTickets $$
DROP PROCEDURE IF EXISTS SP_GetTicketByID $$
DROP PROCEDURE IF EXISTS SP_GetTicketsByEventID $$
DROP PROCEDURE IF EXISTS SP_CreateTicket $$
DROP PROCEDURE IF EXISTS SP_UpdateTicket $$
DROP PROCEDURE IF EXISTS SP_DeleteTicket $$
DROP PROCEDURE IF EXISTS SP_GetEventByID $$
DROP PROCEDURE IF EXISTS SP_GetAllTickets_NoParam $$
DROP PROCEDURE IF EXISTS SP_KopenTicket $$
DROP PROCEDURE IF EXISTS SP_Ticketophalen $$
DROP PROCEDURE IF EXISTS SP_CreatePrijs $$
DROP PROCEDURE IF EXISTS SP_UpdatePrijs $$
DROP PROCEDURE IF EXISTS SP_DeletePrijs $$
DROP PROCEDURE IF EXISTS SP_GetAllPrijzen $$
DROP PROCEDURE IF EXISTS SP_GetPrijsByID $$
DROP PROCEDURE IF EXISTS SP_CreateOrGetBezoeker $$
DROP PROCEDURE IF EXISTS sp_GetAllVerkopers $$
DROP PROCEDURE IF EXISTS sp_GetVerkoperByNaam $$
DROP PROCEDURE IF EXISTS sp_CreateVerkoper $$
DROP PROCEDURE IF EXISTS sp_DeleteVerkoper $$


CREATE PROCEDURE sp_DeleteVerkoper(
    IN p_id int
)
BEGIN
    -- Verwijder het record in de tabel allergeen
    DELETE FROM verkoper 
    WHERE Id = p_id;

    -- Bepaal hoeveel rijen verwijdert zijn (0 of 1)
    SELECT ROW_COUNT() AS affected;

END $$

CREATE PROCEDURE sp_GetAllVerkopers()
BEGIN
    SELECT
        v.id,
        v.Naam,
        v.SpecialeStatus,
        v.VerkooptSoort,
        v.StandType,
        v.Dagen,
        v.LogoUrl
    FROM verkopers AS v;
END $$


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

CREATE PROCEDURE SP_KopenTicket(IN bezoekerid INT, IN evenementid INT, IN prijsid INT, IN aantalTickets INT, IN datum date)
BEGIN
    INSERT INTO tickets(BezoekerId, EvenementId, PrijsId, AantalTickets, Datum)
    VALUES(bezoekerid, evenementid, prijsid, aantalTickets, datum);
    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_Ticketophalen(IN bezoekerid INT, IN datum date)
BEGIN
    SELECT
        BezoekerId,
        EvenementId,
        PrijsId,
        AantalTickets,
        Datum
    FROM tickets
    WHERE
        Datum = datum &&
        Bezoekerid = bezoekerid;
END $$

-- Admin CRUD for Prijzen
CREATE PROCEDURE SP_CreatePrijs(
    IN p_evenementId INT,
    IN p_datum DATE,
    IN p_tijdslot TIME,
    IN p_tarief DECIMAL(10,2),
    IN p_opmerking TEXT
)
BEGIN
    DECLARE v_duplicate_count INT;

    -- Check if duplicate exists (same event, date, and timeslot)
    SELECT COUNT(*) INTO v_duplicate_count
    FROM prijzen
    WHERE EvenementId = p_evenementId
      AND Datum = p_datum
      AND Tijdslot = p_tijdslot
      AND IsActief = 1;

    -- If duplicate exists, signal error
    IF v_duplicate_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.';
    END IF;

    -- Insert new prijs
    INSERT INTO prijzen (EvenementId, Datum, Tijdslot, Tarief, IsActief, Opmerking)
    VALUES (p_evenementId, p_datum, p_tijdslot, p_tarief, 1, p_opmerking);

    SELECT LAST_INSERT_ID() AS id;
END $$

CREATE PROCEDURE SP_UpdatePrijs(
    IN p_id INT,
    IN p_evenementId INT,
    IN p_datum DATE,
    IN p_tijdslot TIME,
    IN p_tarief DECIMAL(10,2),
    IN p_isActief TINYINT,
    IN p_opmerking TEXT
)
BEGIN
    DECLARE v_duplicate_count INT;

    -- Check if duplicate exists (excluding current record)
    SELECT COUNT(*) INTO v_duplicate_count
    FROM prijzen
    WHERE EvenementId = p_evenementId
      AND Datum = p_datum
      AND Tijdslot = p_tijdslot
      AND IsActief = 1
      AND id != p_id;

    -- If duplicate exists, signal error
    IF v_duplicate_count > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Er bestaat al een prijs voor dit evenement op deze datum en dit tijdslot.';
    END IF;

    -- Update prijs
    UPDATE prijzen
    SET
        EvenementId = p_evenementId,
        Datum = p_datum,
        Tijdslot = p_tijdslot,
        Tarief = p_tarief,
        IsActief = p_isActief,
        Opmerking = p_opmerking,
        DatumGewijzigd = NOW()
    WHERE id = p_id;

    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_DeletePrijs(IN p_id INT)
BEGIN
    -- Soft delete: set IsActief to 0 instead of hard delete
    -- This prevents foreign key constraint errors when tickets reference this prijs
    UPDATE prijzen
    SET IsActief = 0,
        DatumGewijzigd = NOW()
    WHERE id = p_id;

    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_GetAllPrijzen()
BEGIN
    SELECT
        p.id,
        p.EvenementId,
        e.Naam AS EventNaam,
        p.Datum,
        p.Tijdslot,
        p.Tarief,
        p.IsActief,
        p.Opmerking,
        p.DatumAangemaakt,
        p.DatumGewijzigd
    FROM prijzen AS p
    LEFT JOIN evenements AS e ON p.EvenementId = e.id
    WHERE p.IsActief = 1
    ORDER BY p.Datum DESC, p.Tijdslot;
END $$

CREATE PROCEDURE SP_GetPrijsByID(IN p_id INT)
BEGIN
    SELECT
        p.id,
        p.EvenementId,
        e.Naam AS EventNaam,
        p.Datum,
        p.Tijdslot,
        p.Tarief,
        p.IsActief,
        p.Opmerking,
        p.DatumAangemaakt,
        p.DatumGewijzigd
    FROM prijzen AS p
    LEFT JOIN evenements AS e ON p.EvenementId = e.id
    WHERE p.id = p_id;
END $$

-- Create or get existing bezoeker by email
CREATE PROCEDURE SP_CreateOrGetBezoeker(
    IN p_email VARCHAR(255),
    IN p_naam VARCHAR(255)
)
BEGIN
    DECLARE v_bezoeker_id INT;

    -- Check if bezoeker exists (using COLLATE to fix collation mismatch)
    SELECT id INTO v_bezoeker_id
    FROM bezoekers
    WHERE EmailAdres COLLATE utf8mb4_unicode_ci = p_email COLLATE utf8mb4_unicode_ci
    LIMIT 1;

    -- If not exists, create new bezoeker
    IF v_bezoeker_id IS NULL THEN
        INSERT INTO bezoekers (Naam, EmailAdres, IsActief)
        VALUES (p_naam, p_email, 1);

        SET v_bezoeker_id = LAST_INSERT_ID();
    END IF;

    SELECT v_bezoeker_id AS id, p_email AS EmailAdres;
END $$


CREATE PROCEDURE SP_GetEventByID(IN eventId INT)
BEGIN
    SELECT
        id,
        Naam,
        Locatie,
        Datum
    FROM
        evenements
    WHERE
        id = eventId;
END $$

CREATE PROCEDURE SP_GetAllEvents ()
BEGIN
    SELECT
        id,
        Naam,
        Locatie,
        Datum
    FROM
        evenements;
END $$

CREATE PROCEDURE SP_GetAllTickets (IN eventId INT)
BEGIN
    -- Return price/time slots (prijzen) for a given event
    SELECT
        p.id AS PrijsID,
        e.Naam AS EventNaam,
        p.Tarief AS TicketPrijs,
        p.Tijdslot AS TicketTijdslot,
        p.Datum AS TicketDatum,
        e.Locatie AS EventLocatie
    FROM
        prijzen AS p
    LEFT JOIN
        evenements AS e ON p.EvenementId = e.id
    WHERE
        e.id = eventId
        AND p.IsActief = 1;
END $$

-- Backwards-compatible: return all prijzen when no eventId is provided
CREATE PROCEDURE SP_GetAllTickets_NoParam ()
BEGIN
    SELECT
        p.id AS PrijsID,
        e.Naam AS EventNaam,
        p.Tarief AS TicketPrijs,
        p.Tijdslot AS TicketTijdslot,
        p.Datum AS TicketDatum,
        e.Locatie AS EventLocatie
    FROM
        prijzen AS p
    LEFT JOIN
        evenements AS e ON p.EvenementId = e.id
    WHERE
        p.IsActief = 1;
END $$

CREATE PROCEDURE SP_GetTicketByID (IN ticketId INT)
BEGIN
    -- Return a single prijs (ticket) record by its id
    SELECT
        p.id AS PrijsID,
        e.Naam AS EventNaam,
        p.Tarief AS TicketPrijs,
        p.Tijdslot AS TicketTijdslot,
        p.Datum AS TicketDatum,
        e.Locatie AS EventLocatie
    FROM
        prijzen AS p
    LEFT JOIN
        evenements AS e ON p.EvenementId = e.id
    WHERE
        p.id = ticketId
        AND p.IsActief = 1;
END $$

CREATE PROCEDURE SP_GetTicketsByEventID (IN eventId INT)
BEGIN
    -- Alias of SP_GetAllTickets for compatibility
    SELECT
        p.id,
        p.Tarief,
        p.Tijdslot,
        p.Datum
    FROM
        prijzen AS p
    WHERE
        p.EvenementId = eventId &&
        p.IsActief = 1
    ORDER BY
        p.Datum, p.Tijdslot;
END $$

CREATE PROCEDURE SP_CreateTicket (
    IN eventId INT,
    IN prijs DECIMAL(10,2),
    IN tijdslot TIME,
    IN datum DATE
)
BEGIN
    INSERT INTO prijzen (EvenementId, Tarief, Tijdslot, Datum)
    VALUES (eventId, prijs, tijdslot, datum);

    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_UpdateTicket (
    IN id INT,
    IN prijs DECIMAL(10,2),
    IN tijdslot TIME,
    IN datum DATE,
    IN eventId INT
)
BEGIN
    UPDATE prijzen
    SET Tarief = prijs,
        Tijdslot = tijdslot,
        Datum = datum,
        EvenementId = eventId
    WHERE id = id;

    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_DeleteTicket (IN id INT)
BEGIN
    DELETE FROM prijzen WHERE id = id;
    SELECT ROW_COUNT() AS Affected;
END $$

DELIMITER ;



