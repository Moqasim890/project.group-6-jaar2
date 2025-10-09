USE laravel;

DELIMITER $$

DROP PROCEDURE IF EXISTS SP_GetAllEvents $$
DROP PROCEDURE IF EXISTS SP_GetAllTickets $$
DROP PROCEDURE IF EXISTS SP_GetTicketByID $$
DROP PROCEDURE IF EXISTS SP_GetTicketsByEventID $$
DROP PROCEDURE IF EXISTS SP_CreateTicket $$
DROP PROCEDURE IF EXISTS SP_UpdateTicket $$
DROP PROCEDURE IF EXISTS SP_DELETETICKET $$

CREATE PROCEDURE SP_GetAllEvents ()
BEGIN
    SELECT
        Id,
        Naam,
        Locatie,
        Datum
    FROM
        evenements;
END $$

CREATE PROCEDURE SP_GetAllTickets (IN eventId INT)
BEGIN
    SELECT
        tCKT.ID AS TicketID,
        EVNt.Naam AS EventNaam,
        tCKT.Tarief AS TicketPrijs,
        tCKT.Tijdslot AS TicketTijdslot,
        TCKT.Datum AS TicketDatum,
        EVNT.LOcatie AS EventLocatie
    FROM
        Prijs AS tCKT
    LEFT JOIN
        evenements AS EVNt ON tCKT.evenementsID = EVNt.ID
    WHERE
        EVNt.ID = eventId;
END $$

CREATE PROCEDURE SP_GetTicketByID (IN ticketId INT)
BEGIN
    SELECT
        tCKT.ID AS TicketID,
        EVNt.Naam AS EventNaam,
        tCKT.Tarief AS TicketPrijs,
        tCKT.Tijdslot AS TicketTijdslot,
        TCKT.Datum AS TicketDatum,
        EVNT.LOcatie AS EventLocatie
    FROM
        Prijs AS tCKT
    LEFT JOIN
        Evenement AS EVNt ON tCKT.EvenementID = EVNt.ID
    WHERE
        tCKT.ID = ticketId;
END $$

CREATE PROCEDURE SP_GetTicketsByEventID (IN eventId INT)
BEGIN
    SELECT
        tCKT.ID AS TicketID,
        EVNt.Naam AS EventNaam,
        tCKT.Tarief AS TicketPrijs,
        tCKT.Tijdslot AS TicketTijdslot,
        TCKT.Datum AS TicketDatum,
        EVNT.LOcatie AS EventLocatie
    FROM
        Prijs AS tCKT
    LEFT JOIN
        evenements AS EVNt ON tCKT.EvenementID = EVNt.ID
    WHERE
        EVNt.ID = eventId;
END $$

CREATE PROCEDURE SP_CreateTicket (
    IN id INT,
    IN prijs DECIMAL(10,2),
    IN tijdslot DATETIME,
    IN datum VARCHAR(255)
)
BEGIN
    INSERT INTO Prijs (EvenementID, Tarief, Tijdslot, Datum)
    VALUES (id, prijs, tijdslot, datum);

    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_UpdateTicket (
    IN id INT,
    IN prijs DECIMAL(10,2),
    IN tijdslot DATETIME,
    IN datum VARCHAR(255),
    IN eventId INT
)
BEGIN
    UPDATE Prijs
    SET Tarief = prijs,
        Tijdslot = tijdslot,
        Datum = datum,
        EvenementID = eventId
    WHERE ID = id;

    SELECT ROW_COUNT() AS Affected;
END $$

CREATE PROCEDURE SP_DELETETICKET (IN id INT)
BEGIN
    DELETE FROM Prijs WHERE ID = id ;
    SELECT ROW_COUNT() AS Affected;
END $$


DELIMITER ;



