CREATE PROCEDURE sp_pessoasvalores_list()
BEGIN

	SELECT a.*, b.despessoa, c.descampo FROM tb_pessoasvalores a
		INNER JOIN tb_pessoas b ON a.idpessoa = b.idpessoa
        INNER JOIN tb_pessoasvalorescampos c ON a.idcampo = c.idcampo;

END