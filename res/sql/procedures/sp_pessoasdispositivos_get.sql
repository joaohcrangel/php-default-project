CREATE PROCEDURE sp_pessoasdispositivos_get(
piddispositivo INT
)
BEGIN

    SELECT *    
    FROM tb_pessoasdispositivos    
    WHERE iddispositivo = piddispositivo;

END