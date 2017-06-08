CREATE PROCEDURE sp_sectionsfromcourse_list(
pidcourse INT
)
BEGIN

    SELECT * FROM tb_coursessections
    WHERE idcourse = pidcourse ORDER BY nrorder;

END