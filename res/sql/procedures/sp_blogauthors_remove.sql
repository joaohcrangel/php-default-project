CREATE PROCEDURE sp_blogauthors_remove(
pidauthor INT
)
BEGIN

    DELETE FROM tb_blogauthors 
    WHERE idauthor = pidauthor;

END