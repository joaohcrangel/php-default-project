CREATE PROCEDURE sp_documento_remove(
piddocumento INT
)
BEGIN

    DELETE FROM tb_documentos WHERE iddocumento = piddocumento;

END