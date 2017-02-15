CREATE PROCEDURE sp_sitescontatos_remove(
pidsitecontato INT
)
BEGIN
	
	DELETE FROM tb_sitescontatos WHERE idsitecontato = pidsitecontato;
    
END