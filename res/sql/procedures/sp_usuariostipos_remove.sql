CREATE PROCEDURE sp_usuariostipos_remove(
pidusuariotipo INT
)
BEGIN

    DELETE FROM tb_usuariostipos 
    WHERE idusuariotipo = pidusuariotipo;

END