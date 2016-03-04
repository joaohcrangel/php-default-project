CREATE PROCEDURE sp_documento_get(
piddocumento INT
)
BEGIN

    SELECT
    iddocumento, iddocumentotipo, idpessoa, desdocumento, dtcadastro
    
    FROM tb_documentos

    WHERE iddocumento = piddocumento;

END