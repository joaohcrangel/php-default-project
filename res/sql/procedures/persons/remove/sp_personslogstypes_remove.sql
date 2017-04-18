CREATE PROCEDURE sp_personslogstypes_remove(
pidlogtype INT
)
BEGIN

    DELETE FROM tb_personslogstypes 
    WHERE idlogtype = pidlogtype;

END