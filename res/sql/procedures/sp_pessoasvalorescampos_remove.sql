CREATE PROCEDURE sp_pessoasvalorescampos_remove(
pidcampo INT
)
BEGIN

	DELETE FROM tb_pessoasvalorescampos WHERE idcampo = pidcampo;

END