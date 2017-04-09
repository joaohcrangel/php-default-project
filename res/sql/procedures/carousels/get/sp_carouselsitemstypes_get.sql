CREATE PROCEDURE sp_carouselsitemstypes_get(
pidtype INT
)
BEGIN

    SELECT *    
    FROM tb_carouselsitemstypes    
    WHERE idtype = pidtype;

END