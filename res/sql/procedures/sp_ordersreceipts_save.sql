CREATE PROCEDURE sp_ordersreceipts_save(
pidreceipt INT,
pdesauthentication VARCHAR(256)
)
BEGIN
	
	IF EXISTS(SELECT * FROM tb_ordersreceipts WHERE idorder = pidorder) THEN
    
		UPDATE tb_ordersreceipts SET
			desauthentication = pdesauthentication
		WHERE idorder = pidorder;
        
	ELSE
    
		INSERT INTO tb_ordersreceipts(idorder, desautenticacao)
        VALUES(pidorder, pdesauthentication);
        
	END IF;
    
    CALL sp_ordersreceipts_get(pidorder);
    
END