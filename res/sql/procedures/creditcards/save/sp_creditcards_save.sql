CREATE PROCEDURE sp_creditcards_save(
pidcard INT,
pidperson INT,
pdesname VARCHAR(64),
pdtvalidity DATE,
pnrcds VARCHAR(8),
pdesnumber CHAR(16)
)
BEGIN
	
	IF ppidcard = 0 THEN
    
		INSERT INTO tb_creditcards(idperson, desname, dtvalidity, nrcds, desnumber)
        VALUES(pidperson, pdesname, pdtvalidity, pnrcds, pdesnumber);
        
		SET pidcard = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_creditcards SET        
			idperson = pidperson,
            desname = pdesname,
            dtvalidity = pdtvalidity,
            nrcds = pnrcds,
            desnumber = pdesnumber
		WHERE idcard = pidcard;
        
	END IF;
    
    CALL sp_creditcards_get(pidcard);

END