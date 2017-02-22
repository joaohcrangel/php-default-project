CREATE PROCEDURE sp_pessoasenderecos_save(
pidpessoa INT,
pidendereco INT
)
BEGIN
	
    DELETE FROM tb_pessoasenderecos WHERE idpessoa = pidpessoa AND idendereco = pidendereco;
    INSERT INTO tb_pessoasenderecos (idpessoa, idendereco) VALUES(pidpessoa, pidendereco);
    
END