CREATE PROCEDURE sp_blogposts_get(
pidpost INT
)
BEGIN

    SELECT *    
    FROM tb_blogposts    
    WHERE idpost = pidpost;

END