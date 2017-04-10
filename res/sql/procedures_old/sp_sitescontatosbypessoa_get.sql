CREATE PROCEDURE sp_sitescontatosbypessoa_get(
pdesemail VARCHAR(128)
)
BEGIN
    
    DECLARE pidpessoa INT;
        
	SELECT
    idpessoa INTO pidpessoa
    FROM tb_contatos
    WHERE
		descontato = pdesemail;
	
	IF pidpessoa > 0 THEN
    
		CALL sp_pessoas_get(pidpessoa);
        
	END IF;

END