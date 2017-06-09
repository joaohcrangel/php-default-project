CREATE PROCEDURE sp_carouselsitems_get(
piditem INT
)
BEGIN

    SELECT a.*, b.*, CONCAT(b.desdirectory, b.desfile, '.', b.desextension) AS descover FROM tb_carouselsitems a
   		LEFT JOIN tb_files b ON a.idcover = b.idfile
    WHERE iditem = piditem;

END