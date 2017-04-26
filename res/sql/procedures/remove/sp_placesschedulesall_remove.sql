CREATE PROCEDURE sp_placesschedulesall_remove(
pidplace INT
)
BEGIN

	DELETE FROM tb_placesschedules
    WHERE idplace = pidplace;

END