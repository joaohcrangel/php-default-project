CREATE PROCEDURE sp_blogpoststags_remove(
pidpost INT
)
BEGIN

    DELETE FROM tb_blogpoststags WHERE idpost = pidpost;

END