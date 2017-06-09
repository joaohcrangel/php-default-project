CREATE PROCEDURE sp_tags_remove(
pidtag INT
)
BEGIN

    DELETE FROM tb_tags 
    WHERE idtag = pidtag;

END;