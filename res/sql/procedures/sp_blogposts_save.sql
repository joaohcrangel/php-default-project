CREATE PROCEDURE sp_blogposts_save(
pidpost INT,
pdestitle VARCHAR(128),
pidurl INT,
pdescontentshort VARCHAR(256),
pdescontent TEXT,
pidauthor INT,
pdtpublished DATETIME,
pintrash BIT,
pidcover INT
)
BEGIN

    IF pidpost = 0 THEN
    
        INSERT INTO tb_blogposts (destitle, idurl, descontentshort, descontent, idauthor, dtpublished, intrash, idcover)
        VALUES(pdestitle, pidurl, pdescontentshort, pdescontent, pidauthor, pdtpublished, pintrash, pidcover);
        
        SET pidpost = LAST_INSERT_ID();

    ELSE
        
        UPDATE tb_blogposts        
        SET 
            destitle = pdestitle,
            idurl = pidurl,
            descontentshort = pdescontentshort,
            descontent = pdescontent,
            idauthor = pidauthor,
            dtpublished = pdtpublished,
            intrash = pintrash,
            idcover = pidcover
        WHERE idpost = pidpost;

    END IF;

    CALL sp_blogposts_get(pidpost);

END