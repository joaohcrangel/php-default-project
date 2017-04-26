CREATE PROCEDURE sp_coursessections_get(
idsection INT
)
BEGIN

    SELECT *    
    FROM tb_coursessections    
    WHERE idsection = pidsection;

END