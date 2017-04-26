CREATE PROCEDURE sp_blogtags_get(
pidtag INT
)
BEGIN

    SELECT *    
    FROM tb_blogtags    
    WHERE idtag = pidtag;

END