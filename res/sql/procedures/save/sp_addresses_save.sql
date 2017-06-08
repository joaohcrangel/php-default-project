CREATE PROCEDURE sp_addresses_save(
pidaddress INT,
pidaddresstype INT,
pdesaddress VARCHAR(64),
pdesnumber VARCHAR(16),
pdesdistrict VARCHAR(64),
pdescity VARCHAR(64),
pdesstate VARCHAR(32),
pdescountry VARCHAR(32),
pdescep CHAR(8),
pdescomplement VARCHAR(32),
pinmain BIT
)
BEGIN

    IF pidaddress = 0 THEN
    
        INSERT INTO tb_addresses (idaddresstype, desaddress, desnumber, desdistrict, descity, desstate, descountry, descep, descomplement, inmain)
        VALUES(pidaddresstype, pdesaddress, pdesnumber, pdesdistrict, pdescity, pdesstate, pdescountry, pdescep, pdescomplement, pinmain);
        
        SET pidaddress = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_addresses        
        SET 
            idaddresstype = pidaddresstype,
            desaddress = pdesaddress,
            desnumber = pdesnumber,
            desdistrict = pdesdistrict,
            descity = pdescity,
            desstate = pdesstate,
            descountry = pdescountry,
            descep = pdescep,
            descomplement = pdescomplement,
            inmain = pinmain
        WHERE idaddress = pidaddress;

    END IF;

    CALL sp_addresses_get(pidaddress);

END