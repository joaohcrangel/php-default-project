CREATE PROCEDURE sp_ordersnegotiationstypes_remove(
pidnegotiation INT
)
BEGIN

    DELETE FROM tb_ordersnegotiationstypes 
    WHERE idnegotiation = pidnegotiation;

END