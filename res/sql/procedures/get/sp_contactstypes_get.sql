CREATE PROCEDURE sp_contactstypes_get(
pidcontacttype INT
)
BEGIN

    SELECT *    
    FROM tb_contactstypes    
    WHERE idcontacttype = pidcontacttype;

END