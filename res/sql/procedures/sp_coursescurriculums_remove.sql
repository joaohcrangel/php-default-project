CREATE PROCEDURE sp_coursescurriculums_remove(
pidcurriculum INT
)
BEGIN

    DELETE FROM tb_coursescurriculums 
    WHERE idcurriculum = pidcurriculum;

END