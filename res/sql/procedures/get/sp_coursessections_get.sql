CREATE PROCEDURE sp_coursessections_get(
pidsection INT
)
BEGIN

    SELECT *    
    FROM tb_coursessections    
    WHERE idsection = pidsection;

END