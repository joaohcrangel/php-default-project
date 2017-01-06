CREATE PROCEDURE sp_sitecontatos_get(
pidsitecontato INT
)
BEGIN
	
	SELECT * FROM tb_sitecontatos a
		INNER JOIN tb_pessoas USING(idpessoa)
	WHERE a.idsitecontato = pidsitecontato;
    
END