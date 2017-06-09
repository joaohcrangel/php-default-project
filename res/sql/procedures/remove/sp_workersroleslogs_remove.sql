CREATE PROCEDURE sp_workersroleslogs_remove(
pidhistory INT
)
BEGIN

    DELETE FROM tb_workersroleslogs 
    WHERE idhistory = pidhistory;

END;