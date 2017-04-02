CREATE PROCEDURE sp_blogposts_remove(
pidpost INT
)
BEGIN

    DELETE FROM tb_blogposts 
    WHERE idpost = pidpost;

END