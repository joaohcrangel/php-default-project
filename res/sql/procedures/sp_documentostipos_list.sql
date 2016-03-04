CREATE PROCEDURE sp_documentostipos_list()
BEGIN
	
	SELECT * 
	FROM tb_documentostipos
	ORDER BY desdocumentotipo;
    
END