CREATE PROCEDURE sp_usuario_remove(
pidusuario INT
)
BEGIN

    DELETE FROM tb_usuarios WHERE idusuario = pidusuario;

END