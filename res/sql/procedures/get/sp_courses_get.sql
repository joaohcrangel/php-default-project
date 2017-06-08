CREATE PROCEDURE sp_courses_get(
pidcourse INT
)
BEGIN

    SELECT a.idcourse, a.descourse, a.destitle, a.vlworkload, a.nrlessons, a.nrexercises, a.inremoved, c.*, f.* FROM tb_courses a
    	LEFT JOIN tb_productscourses e ON a.idcourse = e.idcourse
    	LEFT JOIN tb_products f ON e.idproduct = f.idproduct
    	LEFT JOIN tb_productsurls b ON a.idcourse = b.idcourse
    	LEFT JOIN tb_urls c ON b.idurl = c.idurl    	
    WHERE a.idcourse = pidcourse;

END