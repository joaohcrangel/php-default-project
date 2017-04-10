CREATE PROCEDURE sp_lugares_save(
pidlugar INT,
pidlugarpai INT,
pdeslugar VARCHAR(128),
pidlugartipo INT,
pdesconteudo TEXT,
pnrviews INT,
pvlreview DECIMAL(10,2)
)
BEGIN

    IF pidlugar = 0 THEN
    
        INSERT INTO tb_lugares (idlugarpai, deslugar, idlugartipo, desconteudo, nrviews, vlreview)
        VALUES(pidlugarpai, pdeslugar, pidlugartipo, pdesconteudo, pnrviews, pvlreview);
        
        SET pidlugar = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_lugares        
        SET 
            idlugarpai = pidlugarpai,
            deslugar = pdeslugar,
            idlugartipo = pidlugartipo,
            desconteudo = pdesconteudo,
            nrviews = pnrviews,
            vlreview = pvlreview        
        WHERE idlugar = pidlugar;

    END IF;

    CALL sp_lugares_get(pidlugar);

END