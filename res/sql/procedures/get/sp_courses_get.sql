CREATE PROCEDURE sp_courses_get(
pidcourse INT
)
BEGIN

    SELECT a.*, c.* FROM tb_courses a
    	LEFT JOIN tb_coursesurls b ON a.idcourse = b.idcourse
    	LEFT JOIN tb_urls c ON b.idurl = c.idurl
    WHERE a.idcourse = pidcourse;

END