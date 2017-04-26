CREATE PROCEDURE sp_places_save(
pidplace INT,
pidplacefather INT,
pdesplace VARCHAR(128),
pidplacetype INT,
pdescontent TEXT,
pnrviews INT,
pvlreview DECIMAL(10,2)
)
BEGIN

    IF pidplace = 0 THEN
    
        INSERT INTO tb_places (idplacefather, desplace, idplacetype, descontent, nrviews, vlreview)
        VALUES(pidplacefather, pdesplace, pidplacetype, pdescontent, pnrviews, pvlreview);
        
        SET pidplace = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_places        
        SET 
            idplacefather = pidplacefather,
            desplace = pdesplace,
            idplacetype = pidplacetype,
            descontent = pdescontent,
            nrviews = pnrviews,
            vlreview = pvlreview        
        WHERE idplace = pidplace;

    END IF;

    CALL sp_places_get(pidplace);

END