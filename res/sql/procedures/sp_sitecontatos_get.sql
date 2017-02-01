CREATE PROCEDURE sp_sitecontatos_get(
pidsitecontato INT
)
BEGIN
	
	SELECT * FROM tb_sitecontatos a
		INNER JOIN tb_pessoas b USING(idpessoa)
		INNER JOIN tb_usuarios c ON b.idpessoa = c.idpessoa
	WHERE a.idsitecontato = pidsitecontato;
    
END