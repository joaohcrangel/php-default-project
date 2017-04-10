CREATE PROCEDURE sp_settingstypes_get(
pidsettingtype INT
)
BEGIN

    SELECT *    
    FROM tb_settingstypes    
    WHERE idsettingtype = pidsettingtype;

END