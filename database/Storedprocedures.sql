
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
        e.id = eventId;
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
        evenements AS e ON p.EvenementId = e.id;
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
        p.id = ticketId;
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



