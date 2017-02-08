CREATE PROCEDURE sp_enderecos_get(
pidendereco INT
)
BEGIN

    SELECT
    idendereco, idenderecotipo, desendereco, dtcadastro
    
    FROM tb_enderecos

    WHERE idendereco = pidendereco;

END