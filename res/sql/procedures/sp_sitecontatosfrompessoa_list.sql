CREATE PROCEDURE sp_sitecontatosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * FROM tb_sitecontatos WHERE idpessoa = pidpessoa;

END