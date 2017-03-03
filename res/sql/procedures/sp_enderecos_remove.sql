CREATE PROCEDURE sp_enderecos_remove(
pidendereco INT
)
BEGIN

    IF EXISTS(SELECT * FROM tb_pessoasenderecos WHERE idendereco = pidendereco) THEN
    
		DELETE FROM tb_pessoasenderecos WHERE idendereco = pidendereco;
        
	END IF;

    DELETE FROM tb_enderecos WHERE idendereco = pidendereco;

END