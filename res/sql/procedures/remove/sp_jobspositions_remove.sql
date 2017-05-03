CREATE PROCEDURE sp_jobspositions_remove(
pidjobposition INT
)
BEGIN

    DELETE FROM tb_jobspositions 
    WHERE idjobposition = pidjobposition;

END