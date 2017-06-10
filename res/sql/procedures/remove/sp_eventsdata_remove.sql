CREATE PROCEDURE sp_eventsdata_remove(
pidevent INT
)
BEGIN

	DELETE FROM tb_eventsdata WHERE idevent = pidevent;

END