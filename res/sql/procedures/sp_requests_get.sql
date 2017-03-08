CREATE PROCEDURE sp_requests_get(
pidrequest INT
)
BEGIN
	
	SELECT * FROM tb_requests a
		INNER JOIN tb_persons b ON a.idperson = b.idperson
        INNER JOIN tb_formspayments c ON a.idformrequest = c.idformrequest
        INNER JOIN tb_requestsstatus d ON a.idstatus = d.idstatus
	WHERE a.idpedido = pidrequest;
    
END