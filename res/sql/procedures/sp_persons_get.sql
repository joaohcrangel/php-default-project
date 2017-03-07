CREATE PROCEDURE sp_persons_get (
pidperson INT
)
BEGIN

  SELECT *		  
  FROM tb_personsdata a
  WHERE a.idperson = pidperson;

END