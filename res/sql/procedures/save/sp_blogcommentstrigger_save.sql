CREATE PROCEDURE sp_blogcommentstrigger_save(
pidcomment INT,
pidcommentfather INT
)
BEGIN
	
    DECLARE pnrsubcomments1 INT;
    DECLARE pnrsubcomments2 INT;
    
    SELECT COUNT(*) INTO pnrsubcomments1 
    FROM tb_blogcomments 
    WHERE idcommentfather = pidcomment;
    
    SELECT COUNT(*) INTO pnrsubcomments2 
    FROM tb_blogcomments 
    WHERE idcommentfather = pidcommentfather;
    
    UPDATE tb_blogcomments
    SET nrsubcomments = pnrsubcomments1
    WHERE idcomment = pidcomment;
    
    UPDATE tb_blogcomments
    SET nrsubcomments = pnrsubcomments2
    WHERE idcomment = pidcommentfather;
    
END