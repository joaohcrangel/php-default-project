CREATE PROCEDURE sp_blogposts_remove(
pidpost INT
)
BEGIN

	IF EXISTS(SELECT * FROM tb_blogpostscategories WHERE idpost = pidpost) THEN

		DELETE FROM tb_blogpostscategories WHERE idpost = pidpost;

	END IF;

	IF EXISTS(SELECT * FROM tb_blogpoststags WHERE idpost = pidpost) THEN

		DELETE FROM tb_blogpoststags WHERE idpost = pidpost;

	END IF;
	

    DELETE FROM tb_blogposts 
    WHERE idpost = pidpost;

END