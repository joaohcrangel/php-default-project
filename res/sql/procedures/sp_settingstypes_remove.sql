CREATE PROCEDURE sp_settingstypes_remove(
pidsettingtype INT
)
BEGIN

    DELETE FROM tb_settingstypes 
    WHERE idsettingtype = pidsettingtype;

END