CREATE PROCEDURE sp_documentofrompessoa_list(
pidpessoa INT
)
BEGIN
	
	SELECT * FROM v_documentos WHERE idpessoa = pidpessoa ORDER BY desdocumento;
    
END