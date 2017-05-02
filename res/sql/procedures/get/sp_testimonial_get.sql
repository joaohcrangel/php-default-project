CREATE PROCEDURE sp_testimonial_get(
pidtestimony INT
)
BEGIN

    SELECT *    
    FROM tb_testimonial    
    WHERE idtestimony = pidtestimony;

END