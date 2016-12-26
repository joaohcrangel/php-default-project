CREATE PROCEDURE sp_permissoes_remove(
pidpermissao INT
)
BEGIN
	
    DELETE FROM tb_permissoes WHERE idpermissao = pidpermissao;

END