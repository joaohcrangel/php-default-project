CREATE PROCEDURE sp_materialsproperties_save(
pidproperty INT,
pdesproperty VARCHAR(32),
pdtregister TIMESTAMP
)
BEGIN

    IF pidproperty = 0 THEN
    
        INSERT INTO tb_materialsproperties (desproperty, dtregister)
        VALUES(pdesproperty, pdtregister);
        
        SET pidproperty = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_materialsproperties        
        SET 
            desproperty = pdesproperty,
            dtregister = pdtregister        
        WHERE idproperty = pidproperty;

    END IF;

    CALL sp_materialsproperties_get(pidproperty);

END;