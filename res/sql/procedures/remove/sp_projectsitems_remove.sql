CREATE PROCEDURE sp_projectsitems_remove(
piditem INT
)
BEGIN

    DELETE FROM tb_projectsitems 
    WHERE iditem = piditem;

END;