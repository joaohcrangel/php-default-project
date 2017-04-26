CREATE PROCEDURE sp_persons_remove(
pidperson INT
)
BEGIN
	
	UPDATE tb_persons
	SET inremoved = 1
	WHERE idperson = pidperson;

END