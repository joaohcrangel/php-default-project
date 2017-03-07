CREATE PROCEDURE sp_enderecos_get(
pidendereco INT
)
BEGIN

    SELECT *    
    FROM tb_enderecos

    WHERE idendereco = pidendereco;

END