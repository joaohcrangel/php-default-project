CREATE PROCEDURE sp_socialnetworks_save(
pidsocialnetwork INT,
pdessocialnetwork VARCHAR(128)
)
BEGIN

    IF pidsocialnetwork = 0 THEN
    
        INSERT INTO tb_socialnetworks (dessocialnetwork)
        VALUES(pdessocialnetwork);
        
        SET pidsocialnetwork = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_socialnetworks        
        SET 
            dessocialnetwork = pdessocialnetwork
        WHERE idsocialnetwork = pidsocialnetwork;

    END IF;

    CALL sp_socialnetworks_get(pidsocialnetwork);

END