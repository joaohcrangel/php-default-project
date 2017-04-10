CREATE PROCEDURE sp_cursossecoes_remove(
pidsecao INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_cursoscurriculos WHERE idsecao = pidsecao) THEN
    
		DELETE FROM tb_cursoscurriculos WHERE idsecao = pidsecao;
        
	END IF;

    DELETE FROM tb_cursossecoes 
    WHERE idsecao = pidsecao;

END