CREATE PROCEDURE sp_pagamentoshistoricos_remove(
pidhistorico INT
)
BEGIN

    DELETE FROM tb_pagamentoshistoricos 
    WHERE idhistorico = pidhistorico;

END