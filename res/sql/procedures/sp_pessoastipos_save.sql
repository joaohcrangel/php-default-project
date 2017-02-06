CREATE PROCEDURE sp_pessoastipos_save(
pidpessoatipo INT,
pdespessoatipo VARCHAR(64)
)
BEGIN

    IF pidpessoatipo = 0 THEN
    
        INSERT INTO tb_pessoastipos (despessoatipo)
        VALUES(pdespessoatipo);
        
        SET pidpessoatipo = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_pessoastipos        
        SET 
            despessoatipo = pdespessoatipo        
        WHERE idpessoatipo = pidpessoatipo;

    END IF;

    CALL sp_pessoastipos_get(pidpessoatipo);

END