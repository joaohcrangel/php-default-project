CREATE PROCEDURE sp_curriculumsfromcourse_list(
pidcourse INT
)
BEGIN

    SELECT a.*, b.dessection, b.nrorder, c.descourse, c.destitle, c.vlworkload, c.nrlessons, c.nrexercises,
        c.desdescription AS descoursedescription, c.inremoved
    FROM tb_coursescurriculums a
        INNER JOIN tb_coursessections b ON a.idsection = b.idsection
        INNER JOIN tb_courses c ON b.idcourse = c.idcourse
    WHERE c.idcourse = pidcourse ORDER BY b.nrorder, a.nrorder;

END