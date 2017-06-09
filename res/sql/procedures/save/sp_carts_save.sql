CREATE PROCEDURE sp_carts_save(
pidcart INT,
pidperson INT,
pdessession VARCHAR(128),
pinclosed TINYINT(1),
pnrproducts INT,
pvltotal DECIMAL(10,2),
pvltotalgross DECIMAL(10,2)
)
BEGIN

    IF pidcart = 0 THEN
    
        INSERT INTO tb_carts (idperson, dessession, inclosed, nrproducts, vltotal, vltotalgross)
        VALUES(pidperson, pdessession, pinclosed, pnrproducts, pvltotal, pvltotalgross);
        
        SET pidcart = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_carts        
        SET 
            idperson = pidperson,
            dessession = pdessession,
            inclosed = pinclosed,
            nrproducts = pnrproducts,
            vltotal = pvltotal,
            vltotalgross = pvltotalgross    
        WHERE idcart = pidcart;

    END IF;

    CALL sp_carts_get(pidcart);

END