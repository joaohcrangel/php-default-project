CREATE PROCEDURE sp_workersroleslogs_get(
pidhistory INT
)
BEGIN

    SELECT *    
    FROM tb_workersroleslogs    
    WHERE idhistory = pidhistory;

END;