CREATE PROCEDURE sp_blogauthors_get(
pidauthor INT
)
BEGIN

    SELECT *    
    FROM tb_blogauthors    
    WHERE idauthor = pidauthor;

END