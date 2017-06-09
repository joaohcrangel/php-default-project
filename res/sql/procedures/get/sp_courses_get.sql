CREATE PROCEDURE sp_courses_get(
pidcourse INT
)
BEGIN

    SELECT a.idcourse, a.descourse, a.destitle, a.vlworkload, a.nrlessons, a.nrexercises, a.idbanner, a.idbrasao, a.desshortdescription, a.inremoved,
    a.desurludemy, a.idcourseudemy,
    c.idurl, c.desurl, f.idproduct, f.idproducttype, f.desproduct, f.vlprice, f.desproducttype, f.dtstart, f.dtend,
    f.idprice, f.vlpriceold, f.idpriceold,
        CONCAT(g.desdirectory, g.desfile, ".", g.desextension) AS desbanner,
            CONCAT(h.desdirectory, h.desfile, ".", h.desextension) AS desbrasao FROM tb_courses a
        LEFT JOIN tb_productscourses e ON a.idcourse = e.idcourse
        LEFT JOIN tb_productsdata f ON f.idproduct = e.idproduct
        LEFT JOIN tb_products f1 ON f.idproduct = f1.idproduct
        LEFT JOIN tb_coursesurls b ON a.idcourse = b.idcourse
        LEFT JOIN tb_urls c ON b.idurl = c.idurl
        INNER JOIN tb_files g ON a.idbanner = g.idfile
        INNER JOIN tb_files h ON a.idbrasao = h.idfile
    WHERE a.idcourse = pidcourse;

END