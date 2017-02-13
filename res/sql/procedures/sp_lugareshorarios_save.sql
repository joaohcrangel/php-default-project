CREATE PROCEDURE sp_lugareshorarios_save(
pidhorario INT,
pidlugar INT,
pnrdia TINYINT(4),
phrabre TIME,
phrfecha TIME
)
BEGIN

    IF pidhorario = 0 THEN
    
        INSERT INTO tb_lugareshorarios (idlugar, nrdia, hrabre, hrfecha)
        VALUES(pidlugar, pnrdia, phrabre, phrfecha);
        
        SET pidhorario = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_lugareshorarios        
        SET 
            idlugar = pidlugar,
            nrdia = pnrdia,
            hrabre = phrabre,
            hrfecha = phrfecha        
        WHERE idhorario = pidhorario;

    END IF;

    CALL sp_lugareshorarios_get(pidhorario);

END