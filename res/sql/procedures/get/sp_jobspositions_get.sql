CREATE PROCEDURE sp_jobspositions_get(
pidjobposition INT
)
BEGIN

    SELECT *    
    FROM tb_jobspositions    
    WHERE idjobposition = pidjobposition;

END