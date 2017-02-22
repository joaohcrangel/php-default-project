CREATE PROCEDURE sp_pessoas_save(
pidpessoa INT,
pdespessoa VARCHAR(64),
pidpessoatipo INT,
pdtnascimento DATE,
pdessexo CHAR(1)
)
BEGIN

    IF pidpessoa = 0 THEN
    
        INSERT INTO tb_pessoas (despessoa, idpessoatipo)
        VALUES(pdespessoa, pidpessoatipo);
        
        SET pidpessoa = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_pessoas
        SET 
            despessoa = pdespessoa,
            idpessoatipo = pidpessoatipo
        WHERE idpessoa = pidpessoa;

    END IF;
    
    DELETE FROM tb_pessoasvalores WHERE idpessoa = pidpessoa AND idcampo = 1;
    IF NOT pdtnascimento IS NULL THEN
        
        INSERT INTO tb_pessoasvalores (idpessoa, idcampo, desvalor)
        VALUES(pidpessoa, 1, CAST(pdtnascimento AS DATE));
    
    END IF;
    
    DELETE FROM tb_pessoasvalores WHERE idpessoa = pidpessoa AND idcampo = 2;
    IF NOT pdessexo IS NULL THEN
        
        INSERT INTO tb_pessoasvalores (idpessoa, idcampo, desvalor)
        VALUES(pidpessoa, 2, cast_to_bit(pdessexo));
    
    END IF;

    CALL sp_pessoas_get(pidpessoa);

END