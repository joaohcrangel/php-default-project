CREATE PROCEDURE sp_documentos_remove(
piddocumento INT
)
BEGIN

    DELETE FROM tb_documentos WHERE iddocumento = piddocumento;

END