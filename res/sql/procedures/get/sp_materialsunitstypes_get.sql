CREATE PROCEDURE sp_materialsunitstypes_get(
pidunitytype INT
)
BEGIN

    SELECT *    
    FROM tb_materialsunitstypes    
    WHERE idunitytype = pidunitytype;

END;