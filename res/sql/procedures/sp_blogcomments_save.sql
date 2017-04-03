CREATE PROCEDURE sp_blogcomments_save(
pidcomment INT,
pidcommentfather INT,
pidpost INT,
pidperson INT,
pdescomment TEXT,
pinapproved BIT
)
BEGIN

    IF pidcomment = 0 THEN
    
        INSERT INTO tb_blogcomments (idcommentfather, idpost, idperson, descomment, inapproved)
        VALUES(pidcommentfather, pidpost, pidperson, pdescomment, pinapproved);
        
        SET pidcomment = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_blogcomments        
        SET 
            idcommentfather = pidcommentfather,
            idpost = pidpost,
            idperson = pidperson,
            descomment = pdescomment,
            inapproved = pinapproved
        WHERE idcomment = pidcomment;

    END IF;

    CALL sp_blogcomments_get(pidcomment);

END