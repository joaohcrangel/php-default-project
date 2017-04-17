CREATE PROCEDURE sp_blogauthors_save(
pidauthor INT,
piduser INT,
pdesauthor VARCHAR(32),
pdesresume VARCHAR(512),
pidphoto INT
)
BEGIN

    IF pidauthor = 0 THEN
    
        INSERT INTO tb_blogauthors (iduser, desauthor, desresume, idphoto)
        VALUES(piduser, pdesauthor, pdesresume, pidphoto);
        
        SET pidauthor = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_blogauthors        
        SET 
            iduser = piduser,
            desauthor = pdesauthor,
            desresume = pdesresume,
            idphoto = pidphoto
        WHERE idauthor = pidauthor;

    END IF;

    CALL sp_blogauthors_get(pidauthor);

END