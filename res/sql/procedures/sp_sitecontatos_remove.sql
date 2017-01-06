CREATE PROCEDURE sp_sitecontatos_remove(
pidsitecontato INT
)
BEGIN
	
	DELETE FROM tb_sitecontatos WHERE idsitecontato = pidsitecontato;
    
END