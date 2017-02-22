CREATE PROCEDURE sp_pessoascategoriastipos_get(
pidcategoria INT
)
BEGIN

    SELECT *    
    FROM tb_pessoascategoriastipos    
    WHERE idcategoria = pidcategoria;

END