CREATE PROCEDURE sp_userslogs_save(
pidlog INT,
piduser INT,
pidlogtype INT,
pdeslog VARCHAR(256),
pdesip VARCHAR(64),
pdessession VARCHAR(64),
pdesuseragent VARCHAR(128),
pdespath VARCHAR(256),
pdtregister TIMESTAMP
)
BEGIN

    IF pidlog = 0 THEN
    
        INSERT INTO tb_userslogs (iduser, idlogtype, deslog, desip, dessession, desuseragent, despath, dtregister)
        VALUES(piduser, pidlogtype, pdeslog, pdesip, pdessession, pdesuseragent, pdespath, pdtregister);
        
        SET pidlog = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_userslogs        
        SET 
            iduser = piduser,
            idlogtype = pidlogtype,
            deslog = pdeslog,
            desip = pdesip,
            dessession = pdessession,
            desuseragent = pdesuseragent,
            despath = pdespath,
            dtregister = pdtregister        
        WHERE idlog = pidlog;

    END IF;

    CALL sp_userslogs_get(pidlog);

END