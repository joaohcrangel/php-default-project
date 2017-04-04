CREATE PROCEDURE sp_blogpostscategories_save(
pidpost INT,
pidcategory INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_blogpostscategories WHERE idpost = pidpost AND idcategory = pidcategory) THEN
    
		INSERT INTO tb_blogpostscategories(idpost, idcategory) VALUES(pidpost, pidcategory);
        
	END IF;

END