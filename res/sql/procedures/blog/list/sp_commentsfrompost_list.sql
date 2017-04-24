CREATE PROCEDURE sp_commentsfrompost_list(
pidpost INT
)
BEGIN

	SELECT a.*, b.desperson FROM tb_blogcomments a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
	WHERE idpost = pidpost;

END