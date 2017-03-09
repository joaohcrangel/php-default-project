CREATE PROCEDURE sp_coursescurriculums_get(
pidcurriculum INT
)
BEGIN

    SELECT *
    FROM tb_coursescurriculums
    WHERE idcurriculum = pidcurriculum;

END