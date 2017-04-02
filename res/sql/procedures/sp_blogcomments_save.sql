CREATE PROCEDURE sp_blogcomments_save(
pidcomment INT,
pidcommentfather INT,
pidpost INT,
pidperson INT,
pdescomment TEXT
)
BEGIN

    IF pidcomment = 0 THEN
    
        INSERT INTO tb_blogcomments (idcommentfather, idpost, idperson, descomment)
        VALUES(pidcommentfather, pidpost, pidperson, pdescomment);
        
        SET pidcomment = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_blogcomments        
        SET 
            idcommentfather = pidcommentfather,
            idpost = pidpost,
            idperson = pidperson,
            descomment = pdescomment
        WHERE idcomment = pidcomment;

    END IF;

    CALL sp_blogcomments_get(pidcomment);

END