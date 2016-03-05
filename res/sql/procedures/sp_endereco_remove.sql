CREATE PROCEDURE sp_endereco_remove(
pidendereco INT
)
BEGIN

    DELETE FROM tb_enderecos WHERE idendereco = pidendereco;

END