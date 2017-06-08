CREATE PROCEDURE sp_persons_save(
pidperson INT,
pdesperson VARCHAR(64),
pidpersontype INT,
pdtbirth DATE,
pdessex CHAR(1),
pdesphoto VARCHAR(128),
pdesemail VARCHAR(128),
pdesphone VARCHAR(128),
pdescpf VARCHAR(64),
pdesrg VARCHAR(64),
pdescnpj VARCHAR(64)
)
BEGIN
    
    DECLARE pidemail INT;
    DECLARE pidphone INT;
    DECLARE pidcpf INT;
    DECLARE pidrg INT;
    DECLARE pidcnpj INT;

    SELECT idemail, idphone, idcpf, idrg, idcnpj INTO pidemail, pidphone, pidcpf, pidrg, pidcnpj
    FROM tb_personsdata 
    WHERE idperson = pidperson;
    
    /* Data from person */
    IF pidperson = 0 THEN
    
        INSERT INTO tb_persons (desperson, idpersontype)
        VALUES(pdesperson, pidpersontype);
        
        SET pidperson = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_persons
        SET 
            desperson = pdesperson,
            idpersontype = pidpersontype
        WHERE idperson = pidperson;

    END IF;

    /* E-mail principal */
    IF pdesemail IS NOT NULL AND pidemail > 0 THEN
        UPDATE tb_contacts
        SET descontact = pdesemail
        WHERE idcontact = pidemail;
    ELSEIF pdesemail IS NOT NULL AND pidemail IS NULL THEN
        CALL sp_contacts_save(0, 1, pidperson, pdesemail, 1);
    ELSE
        DELETE FROM tb_contacts
        WHERE idperson = pidperson AND idcontactsubtype = 1;
    END IF;

    /* Telefone principal */
    IF pdesphone IS NOT NULL AND pidphone > 0 THEN
        UPDATE tb_contacts
        SET descontact = pdesphone
        WHERE idcontact = pidphone;
    ELSEIF pdesphone IS NOT NULL AND pidphone IS NULL THEN
        CALL sp_contacts_save(0, 2, pidperson, pdesphone, 1);
    ELSE
        DELETE FROM tb_contacts
        WHERE idperson = pidperson AND idcontactsubtype = 2;
    END IF;

    /* CPF da person */
    IF pdescpf IS NOT NULL AND pidcpf > 0 THEN
        UPDATE tb_documents
        SET desdocument = pdescpf
        WHERE iddocument = pidcpf;
    ELSEIF pdescpf IS NOT NULL AND pidcpf IS NULL THEN
        CALL sp_documents_save(0, 1, pidperson, pdescpf);
    ELSE
        DELETE FROM tb_documents
        WHERE idperson = pidperson AND iddocumenttype = 1;
    END IF;

    /* RG da person */
    IF pdesrg IS NOT NULL AND pidrg > 0 THEN
        UPDATE tb_documents
        SET desdocument = pdesrg
        WHERE iddocument = pidrg;
    ELSEIF pdesrg IS NOT NULL AND pidrg IS NULL THEN
        CALL sp_documents_save(0, 3, pidperson, pdesrg);
    ELSE
        DELETE FROM tb_documents
        WHERE idperson = pidperson AND iddocumenttype = 3;
    END IF;

    /* CNPJ da person */
    IF pdescnpj IS NOT NULL AND pidcnpj > 0 THEN
        UPDATE tb_documents
        SET desdocument = pdescnpj
        WHERE iddocument = pidcnpj;
    ELSEIF pdescnpj IS NOT NULL AND pidcnpj IS NULL THEN
        CALL sp_documents_save(0, 2, pidperson, pdescnpj);
    ELSE
        DELETE FROM tb_documents
        WHERE idperson = pidperson AND iddocumenttype = 2;
    END IF;

    /* Data de Nascimento */
    DELETE FROM tb_personsvalues WHERE idperson = pidperson AND idfield = 1;
    IF NOT pdtbirth IS NULL THEN
        
        INSERT INTO tb_personsvalues (idperson, idfield, desvalue)
        VALUES(pidperson, 1, pdtbirth);
    
    END IF;
        
    /* Sexo */
    DELETE FROM tb_personsvalues WHERE idperson = pidperson AND idfield = 2;
    IF NOT pdessex IS NULL THEN
        
        INSERT INTO tb_personsvalues (idperson, idfield, desvalue)
        VALUES(pidperson, 2, pdessex);
    
    END IF;

    /* Foto */
    DELETE FROM tb_personsvalues WHERE idperson = pidperson AND idfield = 3;
    IF NOT pdesphoto IS NULL THEN
        
        INSERT INTO tb_personsvalues (idperson, idfield, desvalue)
        VALUES(pidperson, 3, pdesphoto);
    
    END IF;

    CALL sp_persons_get(pidperson);

END