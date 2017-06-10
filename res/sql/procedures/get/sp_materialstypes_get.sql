CREATE PROCEDURE sp_materialstypes_get(
pidtype INT
)
BEGIN

    SELECT *    
    FROM tb_materialstypes    
    WHERE idtype = pidtype;

END;