DELIMITER $$

DROP PROCEDURE IF EXISTS SP_DeletePrijs $$

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

DELIMITER ;
