CREATE PROCEDURE sp_pessoa_get (
pidpessoa INT
)
BEGIN

  SELECT *		  
  FROM tb_pessoas 
  WHERE idpessoa = pidpessoa;

END