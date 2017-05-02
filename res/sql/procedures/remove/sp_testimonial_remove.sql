CREATE PROCEDURE sp_testimonial_remove(
pidtestimony INT
)
BEGIN

    DELETE FROM tb_testimonial 
    WHERE idtestimony = pidtestimony;

END