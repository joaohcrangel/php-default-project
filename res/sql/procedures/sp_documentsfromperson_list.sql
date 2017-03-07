CREATE PROCEDURE sp_documentsfromperson_list(
pidperson INT
)
BEGIN
	
	SELECT * FROM tb_documents a
    INNER JOIN tb_documentstypes b USING(iddocumenttype)
    WHERE a.idperson = pidperson ORDER BY desdocument;
    
END