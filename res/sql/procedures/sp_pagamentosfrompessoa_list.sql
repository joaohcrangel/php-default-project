CREATE PROCEDURE sp_pagamentosfrompessoa_list(
pidpessoa INT
)
BEGIN

	SELECT * FROM tb_pagamentos a
		INNER JOIN tb_pessoas USING(idpessoa)
	WHERE a.idpessoa = pidpessoa;

END