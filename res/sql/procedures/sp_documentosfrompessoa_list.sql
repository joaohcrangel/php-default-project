CREATE PROCEDURE sp_documentosfrompessoa_list(
pidpessoa INT
)
BEGIN
	
	SELECT * FROM tb_documentos a
    INNER JOIN tb_documentostipos b USING(iddocumentotipo)
    WHERE a.idpessoa = pidpessoa ORDER BY desdocumento;
    
END