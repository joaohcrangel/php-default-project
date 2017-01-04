CREATE PROCEDURE sp_produtotipo_save(
pidprodutotipo INT,
pdesprodutotipo VARCHAR(64)
)
BEGIN

	IF pidprodutotipo = 0 THEN
    
		INSERT INTO tb_produtostipos(desprodutotipo) VALUES(pdesprodutotipo);
        
        SET pidprodutotipo = LAST_INSERT_ID();
        
	ELSE
    
		UPDATE tb_produtostipos SET
			desprodutotipo = pdesprodutotipo
		WHERE idprodutotipo = pidprodutotipo;
        
	END IF;
    
    CALL sp_produtotipo_get(pidprodutotipo);

END