CREATE PROCEDURE sp_blogpostscategories_remove(
pidpost INT
)
BEGIN

    DELETE FROM tb_blogpostscategories WHERE idpost = pidpost;

END