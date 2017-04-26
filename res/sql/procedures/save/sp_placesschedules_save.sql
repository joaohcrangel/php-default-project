CREATE PROCEDURE sp_placesschedules_save(
pidschedule INT,
pidplace INT,
pnrday TINYINT(4),
phropen TIME,
phrclose TIME
)
BEGIN

    IF pidschedule = 0 THEN
    
        INSERT INTO tb_placesschedules(idplace, nrday, hropen, hrclose)
        VALUES(pidplace, pnrday, phropen, phrclose);
        
        SET pidschedule = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_placesschedules       
        SET 
            idplace = pidplace,
            nrday = pnrday,
            hropen = phropen,
            hrclose = phrclose        
        WHERE idschedule = pidschedule;

    END IF;

    CALL sp_placesschedules_get(pidschedule);

END