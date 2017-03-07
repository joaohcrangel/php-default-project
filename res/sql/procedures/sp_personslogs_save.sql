CREATE PROCEDURE sp_personslogs_save(
pidpersonlog INT,
pidperson INT,
pidlogtype INT,
pdeslog VARCHAR(512)
)
BEGIN

    IF pidpersonlog = 0 THEN
    
        INSERT INTO tb_personslogs (idperson, idlogtype, deslog)
        VALUES(pidperson, pidlogtype, pdeslog);
        
        SET pidpersonlog = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_personslogs        
        SET 
            idperson = pidperson,
            idlogtype = pidlogtype,
            deslog = pdeslog
        WHERE idpersonlog = pidpersonlog;

    END IF;

    CALL sp_personslogs_get(pidpersonlog);

END