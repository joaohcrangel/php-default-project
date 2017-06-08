CREATE PROCEDURE sp_coursescurriculums_save(
pidcurriculum INT,
pdescurriculum VARCHAR(128),
pidsection INT,
pdesdescription VARCHAR(2048),
pnrorder VARCHAR(45)
)
BEGIN

    IF pidcurriculum = 0 THEN
    
        INSERT INTO tb_coursescurriculums (descurriculum, idsection, desdescription, nrorder)
        VALUES(pdescurriculum, pidsection, pdesdescription, pnrorder);
        
        SET pidcurriculum = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_coursescurriculums        
        SET 
            descurriculum = pdescurriculum,
            idsection = pidsection,
            desdescription = pdesdescription,
            nrorder = pnrorder       
        WHERE idcurriculum = pidcurriculum;

    END IF;

    CALL sp_coursescurriculums_get(pidcurriculum);

END