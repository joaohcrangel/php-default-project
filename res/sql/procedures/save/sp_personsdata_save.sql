CREATE PROCEDURE sp_personsdata_save(
pidperson INT
)
BEGIN

    CALL sp_personsdata_remove(pidperson);
    
    INSERT INTO tb_personsdata (
        idperson, desperson,
        desname, desfirstname, deslastname,
        idpersontype, despersontype,
        iduser, desuser, despassword, inblocked ,
        idemail, desemail,
        idphone, desphone,
        idcpf, descpf,
        idcnpj, descnpj,
        idrg, desrg,
        dtupdate,
        dessex,
        dtbirth,
        desphoto,
        inclient, inprovider, incollaborator,
        idaddress, idaddresstype, desaddress, desnumber, 
        desdistrict, descity, desstate, descountry, descep, descomplement,
        desaddresstype
    )
    SELECT 
    a.idperson, a.desperson,
    CONCAT(substring_index(a.desperson, " ", 1), ' ', LEFT(RIGHT(a.desperson, LOCATE(' ', REVERSE(a.desperson)) - 1) , 1), '.') AS desname,
    substring_index(a.desperson, " ", 1) AS desfirstname,
    RIGHT(a.desperson, LOCATE(' ', REVERSE(a.desperson)) - 1) AS deslastname,
    a.idpersontype, b.despersontype,
    c.iduser, c.desuser, c.despassword, c.inblocked,
    d.idcontact AS idemail, d.descontact AS desemail,
    e.idcontact AS idphone, e.descontact AS desphone,
    f.iddocument AS idcpf, f.desdocument AS descpf,
    g.iddocument AS idcnpj, g.desdocument AS descnpj,
    h.iddocument AS idrg, h.desdocument AS desrg,
    NOW(),
    CAST(j.desvalue AS CHAR(1)) AS dessex,
    CAST(k.desvalue AS DATE) AS dtbirth,
    o.desvalue AS desphoto,
    CASE WHEN l.idperson IS NULL THEN 0 ELSE 1 END AS inclient,
    CASE WHEN m.idperson IS NULL THEN 0 ELSE 1 END AS inprovider,
    CASE WHEN n.idperson IS NULL THEN 0 ELSE 1 END AS incollaborator,
    p.idaddress, p.idaddresstype, p.desaddress, p.desnumber, p.desdistrict, 
    p.descity, p.desstate, p.descountry, p.descep , p.descomplement, q.desaddresstype
    FROM tb_persons a
    INNER JOIN tb_personstypes b ON a.idpersontype = b.idpersontype
    LEFT JOIN tb_users c ON c.idperson = a.idperson
    LEFT JOIN tb_contacts d ON d.idcontact = (SELECT d1.idcontact FROM tb_contacts d1 INNER JOIN tb_contactssubtypes d2 ON d1.idcontactsubtype = d2.idcontacttype WHERE d1.idperson = a.idperson AND d2.idcontacttype = 1 ORDER BY d1.inmain DESC LIMIT 1) -- E-MAIL
    LEFT JOIN tb_contacts e ON e.idcontact = (SELECT e1.idcontact FROM tb_contacts e1 INNER JOIN tb_contactssubtypes e2 ON e1.idcontactsubtype = e2.idcontacttype WHERE e1.idperson = a.idperson AND e2.idcontacttype IN(2,3) ORDER BY e1.inmain DESC LIMIT 1) -- PHONE
    LEFT JOIN tb_documents f ON f.iddocument = (SELECT f1.iddocument FROM tb_documents f1 WHERE f1.idperson = a.idperson AND f1.iddocumenttype = 1 LIMIT 1) -- CPF
    LEFT JOIN tb_documents g ON g.iddocument = (SELECT g1.iddocument FROM tb_documents g1 WHERE g1.idperson = a.idperson AND g1.iddocumenttype = 2 LIMIT 1) -- CNPJ
    LEFT JOIN tb_documents h ON h.iddocument = (SELECT h1.iddocument FROM tb_documents h1 WHERE h1.idperson = a.idperson AND h1.iddocumenttype = 3 LIMIT 1) -- RG
    LEFT JOIN tb_personsvalues j ON j.idpersonvalue = (SELECT j1.idpersonvalue FROM tb_personsvalues j1 WHERE j1.idperson = a.idperson AND j1.idfield = 2 LIMIT 1) -- SEX
    LEFT JOIN tb_personsvalues k ON k.idpersonvalue = (SELECT k1.idpersonvalue FROM tb_personsvalues k1 WHERE k1.idperson = a.idperson AND k1.idfield = 1 LIMIT 1) -- DATE OF BIRTH
    LEFT JOIN tb_personsvalues o ON o.idpersonvalue = (SELECT o1.idpersonvalue FROM tb_personsvalues o1 WHERE o1.idperson = a.idperson AND o1.idfield = 3 LIMIT 1) -- FOTO
    LEFT JOIN tb_personscategories l ON a.idperson = l.idperson AND l.idcategory = 1 -- CLIENT
    LEFT JOIN tb_personscategories m ON a.idperson = m.idperson AND m.idcategory = 2 -- PROVIDER
    LEFT JOIN tb_personscategories n ON a.idperson = n.idperson AND n.idcategory = 3 -- COLLABORATOR
    LEFT JOIN tb_addresses p ON p.idaddress = (SELECT p1.idaddress FROM tb_addresses p1 INNER JOIN tb_personsaddresses p2 ON p1.idaddress = p2.idaddress WHERE p2.idperson = a.idperson ORDER by p1.inmain DESC, p2.dtregister DESC LIMIT 1)
    LEFT JOIN tb_addressestypes q ON q.idaddresstype  = p.idaddresstype
    LEFT JOIN tb_personssocialnetworks r ON r.idperson = a.idperson AND r.idsocialnetwork = 1 -- Facebook
    LEFT JOIN tb_personssocialnetworks s ON s.idperson = a.idperson AND s.idsocialnetwork = 2 -- Twitter
    LEFT JOIN tb_personssocialnetworks t ON t.idperson = a.idperson AND t.idsocialnetwork = 3 -- Linkedin
    WHERE 
            a.idperson  = pidperson  
            AND 
            a.inremoved = 0
    LIMIT 1;

END