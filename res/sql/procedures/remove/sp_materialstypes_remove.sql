CREATE PROCEDURE sp_materialstypes_remove(
pidtype INT
)
BEGIN

    DELETE FROM tb_materialstypes 
    WHERE idtype = pidtype;

END;