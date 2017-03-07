CREATE PROCEDURE sp_documentstypes_get(
piddocumenttype INT
)
BEGIN

    SELECT *    
    FROM tb_documentstypes    
    WHERE iddocumenttype = piddocumenttype;

END