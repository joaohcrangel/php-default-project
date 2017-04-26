CREATE PROCEDURE sp_ordersfromperson_list(
pidperson INT
)
BEGIN

	SELECT a.*, b.*, c.desformpayment, d.* FROM tb_orders a
		INNER JOIN tb_persons b USING(idperson)
        INNER JOIN tb_formspayments c ON a.idformpayment = c.idformpayment
        INNER JOIN tb_ordersstatus d ON a.idstatus = d.idstatus
	WHERE a.idperson = pidperson;

END