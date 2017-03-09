CREATE PROCEDURE sp_ordersnegotiationstypes_get(
pidnegotiation INT
)
BEGIN

    SELECT *    
    FROM tb_ordersnegotiationstypes    
    WHERE idnegotiation = pidnegotiation;

END