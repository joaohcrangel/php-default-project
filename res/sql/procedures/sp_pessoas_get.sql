CREATE PROCEDURE sp_pessoas_get (
pidpessoa INT
)
BEGIN

  SELECT *		  
  FROM tb_pessoasdados a
  WHERE a.idpessoa = pidpessoa;

END