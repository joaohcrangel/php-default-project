CREATE PROCEDURE sp_cartoesfrompessoa_list (
pidpessoa INT
)
BEGIN

	SELECT * FROM tb_cartoesdecreditos WHERE idpessoa = pidpessoa;

END
