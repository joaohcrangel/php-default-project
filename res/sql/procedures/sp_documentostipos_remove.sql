CREATE PROCEDURE sp_documentostipos_remove(
piddocumentotipo INT
)
BEGIN

    DELETE FROM tb_documentostipos 
    WHERE iddocumentotipo = piddocumentotipo;

END