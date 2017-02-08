CREATE PROCEDURE sp_documentostipos_get(
piddocumentotipo INT
)
BEGIN

    SELECT *    
    FROM tb_documentostipos    
    WHERE iddocumentotipo = piddocumentotipo;

END