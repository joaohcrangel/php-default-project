CREATE PROCEDURE sp_workers_remove(
pidworker INT
)
BEGIN

    DELETE FROM tb_workers 
    WHERE idworker = pidworker;

END;