CREATE PROCEDURE sp_permissoes_get (
pidpermissao INT
)
BEGIN

  SELECT *		  
  FROM tb_permissoes
  WHERE idpermissao = pidpermissao;

END