CREATE PROCEDURE sp_userstypes_get(
pidusertype INT
)
BEGIN

    SELECT *    
    FROM tb_userstypes    
    WHERE idusertype = pidusertype;

END