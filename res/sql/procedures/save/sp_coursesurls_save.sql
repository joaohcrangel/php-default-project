CREATE PROCEDURE sp_coursesurls_save(
pidcourse INT,
pidurl INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_coursesurls WHERE idcourse = pidcourse AND idurl = pidurl) THEN
    
        INSERT INTO tb_coursesurls(idcourse, idurl) VALUES(pidcourse, pidurl);
        
    END IF;

END