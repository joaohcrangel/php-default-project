CREATE PROCEDURE sp_carrinhos_save(
pidcarrinho INT,
pidpessoa INT,
pdessession VARCHAR(128),
pinfechado BIT,
pnrprodutos INT,
pvltotal DEC(10,2),
pvltotalbruto DEC(10,2)
)
BEGIN
	
	IF pidcarrinho = 0 THEN
    
		INSERT INTO tb_carrinhos(idpessoa, dessession, infechado, nrprodutos, vltotal, vltotalbruto)
        VALUES(pidpessoa, pdessession, pinfechado, pnrprodutos, pvltotal, pvltotalbruto);
        
		SET pidcarrinho = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_carrinhos SET
			idpessoa = pidpessoa,
            dessession = pdessession,
            infechado = pinfechado,
            nrprodutos = pnrprodutos,
            vltotal = pvltotal,
            vltotalbruto = pvltotalbruto
		WHERE idcarrinho = pidcarrinho;
        
	END IF;
    
	CALL sp_carrinhos_get(pidcarrinho);

END