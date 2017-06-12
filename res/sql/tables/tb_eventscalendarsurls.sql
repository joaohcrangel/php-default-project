CREATE TABLE tb_eventscalendarsurls(
idcalendar INT NOT NULL,
idurl INT NOT NULL,
dtregister TIMESTAMP DEFAULT CURRENT_TIMESTAMP(),
CONSTRAINT FK_eventscalendarsurls_eventscalendars FOREIGN KEY(idcalendar) REFERENCES tb_eventscalendars(idcalendar),
CONSTRAINT FK_eventscalendarsurls_urls FOREIGN KEY(idurl) REFERENCES tb_urls(idurl)
);