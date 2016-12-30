CREATE PROCEDURE sp_usuariostipos_get(
pidusuariotipo INT
)
BEGIN

    SELECT *    
    FROM tb_usuariostipos    
    WHERE idusuariotipo = pidusuariotipo;

END