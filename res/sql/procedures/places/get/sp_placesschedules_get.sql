CREATE PROCEDURE sp_placesschedules_get(
pidschedule INT
)
BEGIN

    SELECT *    
    FROM tb_placesschedules    
    WHERE idschedule = pidschedule;

END