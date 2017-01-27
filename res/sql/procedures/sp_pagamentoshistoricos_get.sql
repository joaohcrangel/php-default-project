CREATE PROCEDURE sp_pagamentoshistoricos_get(
pidhistorico INT
)
BEGIN

    SELECT *    
    FROM tb_pagamentoshistoricos    
    WHERE idhistorico = pidhistorico;

END