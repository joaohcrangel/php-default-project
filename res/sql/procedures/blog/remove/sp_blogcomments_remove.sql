CREATE PROCEDURE sp_blogcomments_remove(
pidcomment INT
)
BEGIN

    DELETE FROM tb_blogcomments 
    WHERE idcomment = pidcomment;

END