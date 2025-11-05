UPDATE prijzen p
JOIN evenement e ON e.Id = eventId
SET
    p.Tarief = prijs,
    p.Tijdslot = tijdslot,
    p.Datum = datum,
    p.EvenementId = eventId
WHERE
    p.Id = prijsId
    AND e.Actief != 0;