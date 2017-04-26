CREATE PROCEDURE sp_blogtags_remove(
pidtag INT
)
BEGIN

    DELETE FROM tb_blogtags 
    WHERE idtag = pidtag;

END