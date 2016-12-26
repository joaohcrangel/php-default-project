CREATE PROCEDURE sp_usuarios_remove(
pidusuario INT
)
BEGIN

    DELETE FROM tb_usuarios WHERE idusuario = pidusuario;

END