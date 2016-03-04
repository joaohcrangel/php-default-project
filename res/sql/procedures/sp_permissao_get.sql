CREATE PROCEDURE sp_permissao_get (
pidpermissao INT
)
BEGIN

  SELECT *		  
  FROM tb_permissoes
  WHERE idpermissao = pidpermissao;

END