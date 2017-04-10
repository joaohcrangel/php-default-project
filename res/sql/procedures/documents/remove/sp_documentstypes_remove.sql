CREATE PROCEDURE sp_documentstypes_remove(
piddocumenttype INT
)
BEGIN

    DELETE FROM tb_documentstypes 
    WHERE iddocumenttype = piddocumenttype;

END