CREATE PROCEDURE sp_workersroles_save(
pidrole INT,
pdesrole INT,
pinadmin BIT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidrole = 0 THEN
    
        INSERT INTO tb_workersroles (desrole, inadmin, dtregister)
        VALUES(pdesrole, pinadmin, pdtregister);
        
        SET pidrole = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_workersroles        
        SET 
            desrole = pdesrole,
            inadmin = pinadmin,
            dtregister = pdtregister        
        WHERE idrole = pidrole;

    END IF;

    CALL sp_workersroles_get(pidrole);

END;