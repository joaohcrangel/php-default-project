CREATE PROCEDURE sp_tagsfrompost_list(
pidpost INT
)
BEGIN

	SELECT a.* FROM tb_blogtags a
		INNER JOIN tb_blogpoststags b ON a.idtag = b.idtag
	WHERE b.idpost = pidpost;

END