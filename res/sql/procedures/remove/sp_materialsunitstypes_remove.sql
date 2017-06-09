CREATE PROCEDURE sp_materialsunitstypes_remove(
pidunitytype INT
)
BEGIN

    DELETE FROM tb_materialsunitstypes 
    WHERE idunitytype = pidunitytype;

END;