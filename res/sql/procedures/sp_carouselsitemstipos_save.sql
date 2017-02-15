CREATE PROCEDURE sp_carouselsitemstipos_save(
pidtipo INT,
pdestipo VARCHAR(32)
)
BEGIN

    IF pidtipo = 0 THEN
    
        INSERT INTO tb_carouselsitemstipos (destipo)
        VALUES(pdestipo);
        
        SET pidtipo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carouselsitemstipos        
        SET 
            destipo = pdestipo        
        WHERE idtipo = pidtipo;

    END IF;

    CALL sp_carouselsitemstipos_get(pidtipo);

END