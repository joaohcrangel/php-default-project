CREATE PROCEDURE sp_adresses_save(
pidadress INT,
pidadresstype INT,
pdesadress VARCHAR(64),
pdesnumber VARCHAR(16),
pdesdistrict VARCHAR(64),
pdescity VARCHAR(64),
pdesstate VARCHAR(32),
pdescountry VARCHAR(32),
pdescep CHAR(8),
pdescomplement VARCHAR(32),
pinprincipal BIT
)
BEGIN

    IF pidadress = 0 THEN
    
        INSERT INTO tb_adresses (idadresstype, desadress, desnumber, desdistrict, descity, desstate, descountry, descep, descomplement, inprincipal)
        VALUES(pidadresstype, pdesadress, pdesnumber, pdesdistrict, pdescity, pdesstate, pdescountry, pdescep, pdescomplement, pinprincipal);
        
        SET pidadress = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_adresses        
        SET 
            idadresstype = pidadresstype,
            desadress = pdesadress,
            desnumber = pdesnumber,
            desdistrict = pdesdistrict,
            descity = pdescity,
            desstate = pdesstate,
            descountry = pdescountry,
            descep = pdescep,
            descomplement = pdescomplement,
            inprincipal = pinprincipal
        WHERE idadress = pidadress;

    END IF;

    CALL sp_adresses_get(pidadress);

END