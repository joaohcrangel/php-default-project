CREATE PROCEDURE sp_pessoa_save(
pidpessoa INT,
pdespessoa VARCHAR(64),
pidpessoatipo INT
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

    CALL sp_pessoa_get(pidpessoa);

END