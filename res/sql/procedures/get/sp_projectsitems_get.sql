CREATE PROCEDURE sp_projectsitems_get(
piditem INT
)
BEGIN

    SELECT *    
    FROM tb_projectsitems    
    WHERE iditem = piditem;

END;