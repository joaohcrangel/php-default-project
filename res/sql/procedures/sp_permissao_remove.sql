CREATE PROCEDURE sp_permissao_remove(
pidpermissao INT
)
BEGIN
	
    DELETE FROM tb_permissoes WHERE idpermissao = pidpermissao;

END