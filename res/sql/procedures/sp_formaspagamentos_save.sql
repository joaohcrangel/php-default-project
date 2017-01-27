CREATE PROCEDURE sp_formaspagamentos_save(
pidformapagamento INT,
pidgateway INT,
pdesformapagamento VARCHAR(128),
pnrparcelasmax INT,
pinstatus BIT
)
BEGIN
	
	IF pidformapagamento = 0 THEN
    
		INSERT INTO tb_formaspagamentos(idgateway, desformapagamento, nrparcelasmax, instatus)
        VALUES(pidgateway, pdesformapagamento, pnrparcelasmax, pinstatus);
        
        SET pidformapagamento = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_formaspagamentos SET
			idgateway = pidgateway,
            desformapagamento = pdesformapagamento,
            nrparcelasmax = pnrparcelasmax,
            instatus = pinstatus
		WHERE idformapagamento = pidformapagamento;
        
	END IF;
    
    CALL sp_formaspagamentos_get(pidformapagamento);

END