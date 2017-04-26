CREATE PROCEDURE sp_placesschedules_remove(
pidschedule INT
)
BEGIN

    DELETE FROM tb_placesschedules 
    WHERE idschedule = pidschedule;

END