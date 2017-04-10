CREATE PROCEDURE sp_sitescontatosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * FROM tb_sitescontatos WHERE idpessoa = pidpessoa;

END