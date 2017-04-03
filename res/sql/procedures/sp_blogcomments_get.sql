CREATE PROCEDURE sp_blogcomments_get(
pidcomment INT
)
BEGIN

    SELECT *    
    FROM tb_blogcomments    
    WHERE idcomment = pidcomment;

END