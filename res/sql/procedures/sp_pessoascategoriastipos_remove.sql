CREATE PROCEDURE sp_pessoascategoriastipos_remove(
pidcategoria INT
)
BEGIN

    DELETE FROM tb_pessoascategoriastipos 
    WHERE idcategoria = pidcategoria;

END