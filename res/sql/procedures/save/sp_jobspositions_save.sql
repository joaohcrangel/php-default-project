CREATE PROCEDURE sp_jobspositions_save(
pidjobposition INT,
pdesjobposition VARCHAR(256)
)
BEGIN

    IF pidjobposition = 0 THEN
    
        INSERT INTO tb_jobspositions (desjobposition)
        VALUES(pdesjobposition);
        
        SET pidjobposition = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_jobspositions        
        SET 
            desjobposition = pdesjobposition
        WHERE idjobposition = pidjobposition;

    END IF;

    CALL sp_jobspositions_get(pidjobposition);

END