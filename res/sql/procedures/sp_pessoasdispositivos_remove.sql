CREATE PROCEDURE sp_pessoasdispositivos_remove(
piddispositivo INT
)
BEGIN

    DELETE FROM tb_pessoasdispositivos 
    WHERE iddispositivo = piddispositivo;

END