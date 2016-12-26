CREATE PROCEDURE sp_enderecos_remove(
pidendereco INT
)
BEGIN

    DELETE FROM tb_enderecos WHERE idendereco = pidendereco;

END