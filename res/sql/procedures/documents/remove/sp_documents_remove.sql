CREATE PROCEDURE sp_documents_remove(
piddocument INT
)
BEGIN

    DELETE FROM tb_documents WHERE iddocument = piddocument;

END