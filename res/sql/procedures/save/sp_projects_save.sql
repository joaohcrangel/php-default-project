CREATE PROCEDURE sp_projects_save(
pidproject INT,
pdesproject VARCHAR(128),
pdescode VARCHAR(32),
pidclient INT,
pidsalesman INT,
pdtdue DATE,
pdtdelivery DATE,
pidcalendar INT,
pidformat INT,
pidstandtype INT,
pvlsum DECIMAL(10,2),
pdesdescription TEXT,
pdtregister TIMESTAMP
)
BEGIN

    IF pidproject = 0 THEN
    
        INSERT INTO tb_projects (desproject, descode, idclient, idsalesman, dtdue, dtdelivery, idcalendar, idformat, idstandtype, vlsum, desdescription, dtregister)
        VALUES(pdesproject, pdescode, pidclient, pidsalesman, pdtdue, pdtdelivery, pidcalendar, pidformat, pidstandtype, pvlsum, pdesdescription, pdtregister);
        
        SET pidproject = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_projects        
        SET 
            desproject = pdesproject,
            descode = pdescode,
            idclient = pidclient,
            idsalesman = pidsalesman,
            dtdue = pdtdue,
            dtdelivery = pdtdelivery,
            idcalendar = pidcalendar,
            idformat = pidformat,
            idstandtype = pidstandtype,
            vlsum = pvlsum,
            desdescription = pdesdescription,
            dtregister = pdtregister        
        WHERE idproject = pidproject;

    END IF;

    CALL sp_projects_get(pidproject);

END;