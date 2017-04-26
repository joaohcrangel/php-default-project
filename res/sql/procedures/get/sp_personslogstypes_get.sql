CREATE PROCEDURE sp_personslogstypes_get(
pidlogtype INT
)
BEGIN

    SELECT *    
    FROM tb_personslogstypes    
    WHERE idlogtype = pidlogtype;

END