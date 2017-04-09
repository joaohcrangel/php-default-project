CREATE PROCEDURE sp_blogpoststags_save(
pidpost INT,
pidtag INT
)
BEGIN

    IF NOT EXISTS(SELECT * FROM tb_blogpoststags WHERE idpost = pidpost AND idtag = pidtag) THEN
    
		INSERT INTO tb_blogpoststags(idpost, idtag) VALUES(pidpost, pidtag);
        
	END IF;

END