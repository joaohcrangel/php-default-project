CREATE PROCEDURE sp_emails_save(
pidemail INT,
pdesemail VARCHAR(256),
pdessubject VARCHAR(256),
pdesbody TEXT,
pdesbcc VARCHAR(256),
pdescc VARCHAR(256),
pdesreplyto VARCHAR(256),
pdtregister TIMESTAMP
)
BEGIN

    IF pidemail = 0 THEN
    
        INSERT INTO tb_emails (desemail, dessubject, desbody, desbcc, descc, desreplyto, dtregister)
        VALUES(pdesemail, pdessubject, pdesbody, pdesbcc, pdescc, pdesreplyto, pdtregister);
        
        SET pidemail = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_emails        
        SET 
            desemail = pdesemail,
            dessubject = pdessubject,
            desbody = pdesbody,
            desbcc = pdesbcc,
            descc = pdescc,
            desreplyto = pdesreplyto,
            dtregister = pdtregister        
        WHERE idemail = pidemail;

    END IF;

    CALL sp_emails_get(pidemail);

END