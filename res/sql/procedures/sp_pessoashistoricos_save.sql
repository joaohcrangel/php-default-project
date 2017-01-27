CREATE PROCEDURE sp_pessoashistoricos_save(
pidpessoahistorico INT,
pidpessoa INT,
pidhistoricotipo INT,
pdeshistorico VARCHAR(512)
)
BEGIN

    IF pidpessoahistorico = 0 THEN
    
        INSERT INTO tb_pessoashistoricos (idpessoa, idhistoricotipo, deshistorico)
        VALUES(pidpessoa, pidhistoricotipo, pdeshistorico);
        
        SET pidpessoahistorico = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_pessoashistoricos        
        SET 
            idpessoa = pidpessoa,
            idhistoricotipo = pidhistoricotipo,
            deshistorico = pdeshistorico        
        WHERE idpessoahistorico = pidpessoahistorico;

    END IF;

    CALL sp_pessoashistoricos_get(pidpessoahistorico);

END