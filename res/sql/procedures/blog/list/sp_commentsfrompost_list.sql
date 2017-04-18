CREATE PROCEDURE sp_commentsfrompost_list(
pidpost INT
)
BEGIN

	SELECT * FROM tb_blogcomments WHERE idpost = pidpost;

END