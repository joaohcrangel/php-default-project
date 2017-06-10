CREATE PROCEDURE sp_tags_get(
pidtag INT
)
BEGIN

    SELECT *    
    FROM tb_tags    
    WHERE idtag = pidtag;

END;