CREATE PROCEDURE sp_departments_remove(
piddepartment INT
)
BEGIN

    DELETE FROM tb_departments 
    WHERE iddepartment = piddepartment;

END;