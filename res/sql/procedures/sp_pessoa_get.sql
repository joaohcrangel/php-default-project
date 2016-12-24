CREATE PROCEDURE sp_pessoa_get (
pidpessoa INT
)
BEGIN

  SELECT *		  
  FROM tb_pessoas a
  LEFT JOIN tb_pessoastipos b ON a.idpessoatipo = b.idpessoatipo
  WHERE a.idpessoa = pidpessoa;

END