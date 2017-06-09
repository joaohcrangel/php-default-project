CREATE PROCEDURE sp_itemsfromcarousel_list(
pidcarousel INT
)
BEGIN

    SELECT a.*, b.destype, c.*, CONCAT(c.desdirectory, c.desfile, '.', c.desextension) AS descover FROM tb_carouselsitems a
        INNER JOIN tb_carouselsitemstypes b ON a.idtype = b.idtype
        LEFT JOIN tb_files c ON a.idcover = c.idfile
    WHERE a.idcarousel = pidcarousel;

END