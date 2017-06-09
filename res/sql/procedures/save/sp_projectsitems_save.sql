CREATE PROCEDURE sp_projectsitems_save(
piditem INT,
pdesitem VARCHAR(64),
pdtregister TIMESTAMP
)
BEGIN

    IF piditem = 0 THEN
    
        INSERT INTO tb_projectsitems (desitem, dtregister)
        VALUES(pdesitem, pdtregister);
        
        SET piditem = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projectsitems        
        SET 
            desitem = pdesitem,
            dtregister = pdtregister        
        WHERE iditem = piditem;

    END IF;

    CALL sp_projectsitems_get(piditem);

END;