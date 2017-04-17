CREATE PROCEDURE sp_documents_get(
piddocument INT
)
BEGIN

    SELECT *    
    FROM tb_documents    
    WHERE iddocument = piddocument;

END