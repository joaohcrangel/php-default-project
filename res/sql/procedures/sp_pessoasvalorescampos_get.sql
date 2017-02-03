CREATE PROCEDURE sp_pessoasvalorescampos_get(
pidcampo INT
)
BEGIN

	SELECT * FROM tb_pessoasvalorescampos WHERE idcampo = pidcampo;

END