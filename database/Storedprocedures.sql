USE laravel;

DELIMITER $$

CREATE PROCEDURE SP_GetAllTickets (IN param1 INT)
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
        EVNt.ID = param1;
END $$

CREATE PROCEDURE SP_GetTicketByID (IN param1 INT)
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
        tCKT.ID = param1;
END $$


CREATE PROCEDURE SP_STORETICKET (
    IN param1 INT,
    IN param2 DECIMAL(10,2),
    IN param3 DATETIME,
    IN param4 VARCHAR(255)
)
BEGIN
    INSERT INTO Prijs (EvenementID, Tarief, Tijdslot, Datum)
    VALUES (param1, param2, param3, param4);

    SELECT ROW_COUNT() AS Affected;
END $$


CREATE PROCEDURE SP_DELETETICKET (IN param1 INT)
BEGIN
    DELETE FROM Prijs WHERE ID = param1;
    SELECT ROW_COUNT() AS Affected;
END $$


DELIMITER ;



