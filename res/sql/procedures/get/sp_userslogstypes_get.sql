CREATE PROCEDURE sp_userslogstypes_get(
pidlogtype INT
)
BEGIN

    SELECT *    
    FROM tb_userslogstypes    
    WHERE idlogtype = pidlogtype;

END