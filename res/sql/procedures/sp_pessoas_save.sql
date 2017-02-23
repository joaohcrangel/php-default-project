CREATE PROCEDURE sp_pessoas_save(
pidpessoa INT,
pdespessoa VARCHAR(64),
pidpessoatipo INT,
pdtnascimento DATE,
pdessexo CHAR(1),
pdesfoto VARCHAR(128),
pdesemail VARCHAR(128),
pdestelefone VARCHAR(128),
pdescpf VARCHAR(64),
pdesrg VARCHAR(64),
pdescnpj VARCHAR(64)
)
BEGIN
    
    DECLARE pidemail INT;
    DECLARE pidtelefone INT;
    DECLARE pidcpf INT;
    DECLARE pidrg INT;
    DECLARE pidcnpj INT;

    SELECT idemail, idtelefone, idcpf, idrg, idcnpj INTO pidemail, pidtelefone, pidcpf, pidrg, pidcnpj
    FROM tb_pessoasdados 
    WHERE idpessoa = pidpessoa;
    
    /* Dados da pessoa */
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

    /* E-mail principal */
    IF pdesemail IS NOT NULL AND pidemail > 0 THEN
        UPDATE tb_contatos
        SET descontato = pdesemail
        WHERE idcontato = pidemail;
    ELSEIF pdesemail IS NOT NULL AND pidemail IS NULL THEN
        CALL sp_contatos_save(0, 6, pidpessoa, pdesemail, 1);
    ELSE
        DELETE FROM tb_contatos
        WHERE idpessoa = pidpessoa AND idcontatosubtipo = 6;
    END IF;

    /* Telefone principal */
    IF pdestelefone IS NOT NULL AND pidtelefone > 0 THEN
        UPDATE tb_contatos
        SET descontato = pdestelefone
        WHERE idcontato = pidtelefone;
    ELSEIF pdestelefone IS NOT NULL AND pidtelefone IS NULL THEN
        CALL sp_contatos_save(0, 2, pidpessoa, pdestelefone, 1);
    ELSE
        DELETE FROM tb_contatos
        WHERE idpessoa = pidpessoa AND idcontatosubtipo = 6;
    END IF;

    /* CPF da pessoa */
    IF pdescpf IS NOT NULL AND pidcpf > 0 THEN
        UPDATE tb_documentos
        SET descontato = pdescpf
        WHERE idcontato = pidcpf;
    ELSEIF pdescpf IS NOT NULL AND pidcpf IS NULL THEN
        CALL sp_documentos_save(0, 1, pidpessoa, pdescpf);
    ELSE
        DELETE FROM tb_documentos
        WHERE idpessoa = pidpessoa AND idcontatosubtipo = 6;
    END IF;

    /* RG da pessoa */
    IF pdesrg IS NOT NULL AND pidrg > 0 THEN
        UPDATE tb_documentos
        SET descontato = pdesrg
        WHERE idcontato = pidrg;
    ELSEIF pdesrg IS NOT NULL AND pidrg IS NULL THEN
        CALL sp_documentos_save(0, 3, pidpessoa, pdesrg);
    ELSE
        DELETE FROM tb_documentos
        WHERE idpessoa = pidpessoa AND idcontatosubtipo = 6;
    END IF;

    /* CNPJ da pessoa */
    IF pdescnpj IS NOT NULL AND pidcnpj > 0 THEN
        UPDATE tb_documentos
        SET descontato = pdescnpj
        WHERE idcontato = pidcnpj;
    ELSEIF pdescnpj IS NOT NULL AND pidcnpj IS NULL THEN
        CALL sp_documentos_save(0, 2, pidpessoa, pdescnpj);
    ELSE
        DELETE FROM tb_documentos
        WHERE idpessoa = pidpessoa AND idcontatosubtipo = 6;
    END IF;
    
    /* Data de Nascimento */
    DELETE FROM tb_pessoasvalores WHERE idpessoa = pidpessoa AND idcampo = 1;
    IF NOT pdtnascimento IS NULL THEN
        
        INSERT INTO tb_pessoasvalores (idpessoa, idcampo, desvalor)
        VALUES(pidpessoa, 1, pdtnascimento);
    
    END IF;
        
    /* Sexo */
    DELETE FROM tb_pessoasvalores WHERE idpessoa = pidpessoa AND idcampo = 2;
    IF NOT pdessexo IS NULL THEN
        
        INSERT INTO tb_pessoasvalores (idpessoa, idcampo, desvalor)
        VALUES(pidpessoa, 2, cast_to_bit(pdessexo));
    
    END IF;

    /* Foto */
    DELETE FROM tb_pessoasvalores WHERE idpessoa = pidpessoa AND idcampo = 3;
    IF NOT pdesfoto IS NULL THEN
        
        INSERT INTO tb_pessoasvalores (idpessoa, idcampo, desvalor)
        VALUES(pidpessoa, 3, pdesfoto);
    
    END IF;

    CALL sp_pessoas_get(pidpessoa);

END