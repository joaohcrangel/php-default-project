CREATE PROCEDURE sp_orderslogs_save(
pidlog INT,
pidorder INT,
piduser INT
)
BEGIN

    IF pidlog = 0 THEN
    
		INSERT INTO tb_orderslogs(idorder, iduser)
        VALUES(pidorder, piduser);
        
		SET pidlog = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_orderslogs SET
        
			idorder = pidorder,
            iduser = piduser
            
		WHERE idlog = pidlog;
        
	END IF;
    
    CALL sp_orderslogs_get(pidlog);

END