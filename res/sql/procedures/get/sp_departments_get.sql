CREATE PROCEDURE sp_departments_get(
piddepartment INT
)
BEGIN

    SELECT *    
    FROM tb_departments    
    WHERE iddepartment = piddepartment;

END;