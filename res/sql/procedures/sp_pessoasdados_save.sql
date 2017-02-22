CREATE PROCEDURE sp_pessoasdados_save(
pidpessoa INT
)
BEGIN

    CALL sp_pessoasdados_remove(pidpessoa);
    
    INSERT INTO tb_pessoasdados (
        idpessoa, despessoa,
        desnome, desprimeironome, desultimonome,
        idpessoatipo, despessoatipo,
        idusuario, desusuario, dessenha, inbloqueado,
        idemail, desemail,
        idtelefone, destelefone,
        idcpf, descpf,
        idcnpj, descnpj,
        idrg, desrg,
        dtatualizacao,
        dessexo,
        dtnascimento,
        desfoto,
        incliente, infornecedor, incolaborador
    )
    SELECT 
    a.idpessoa, a.despessoa,
    CONCAT(substring_index(a.despessoa, " ", 1), ' ', LEFT(RIGHT(a.despessoa, LOCATE(' ', REVERSE(a.despessoa)) - 1) , 1), '.') AS desnome,
    substring_index(a.despessoa, " ", 1) AS desprimeironome,
    RIGHT(a.despessoa, LOCATE(' ', REVERSE(a.despessoa)) - 1) AS desultimonome,
    a.idpessoatipo, b.despessoatipo,
    c.idusuario, c.desusuario, c.dessenha, c.inbloqueado,
    d.idcontato AS idemail, d.descontato AS desemail,
    e.idcontato AS idtelefone, e.descontato AS destelefone,
    f.iddocumento AS idcpf, f.desdocumento AS descpf,
    g.iddocumento AS idcnpj, g.desdocumento AS descnpj,
    h.iddocumento AS idrg, h.desdocumento AS desrg,
    NOW(),
    CAST(j.desvalor AS CHAR(1)) AS dessexo,
    CAST(k.desvalor AS DATE) AS dtnascimento,
    CAST(o.desfoto AS DATE) AS desfoto,
    CASE WHEN l.idpessoa IS NULL THEN 0 ELSE 1 END AS incliente,
    CASE WHEN m.idpessoa IS NULL THEN 0 ELSE 1 END AS infornecedor,
    CASE WHEN n.idpessoa IS NULL THEN 0 ELSE 1 END AS incolaborador
    FROM tb_pessoas a
    INNER JOIN tb_pessoastipos b ON a.idpessoatipo = b.idpessoatipo
    LEFT JOIN tb_usuarios c ON c.idpessoa = a.idpessoa
    LEFT JOIN tb_contatos d ON d.idcontato = (SELECT d1.idcontato FROM tb_contatos d1 INNER JOIN tb_contatossubtipos d2 ON d1.idcontatosubtipo = d2.idcontatosubtipo WHERE d1.idpessoa = a.idpessoa AND d2.idcontatotipo = 1 ORDER BY d1.inprincipal DESC LIMIT 1) -- E-MAIL
    LEFT JOIN tb_contatos e ON e.idcontato = (SELECT e1.idcontato FROM tb_contatos e1 INNER JOIN tb_contatossubtipos e2 ON e1.idcontatosubtipo = e2.idcontatosubtipo WHERE e1.idpessoa = a.idpessoa AND e2.idcontatotipo IN(2,3) ORDER BY e1.inprincipal DESC LIMIT 1) -- TELEFONE
    LEFT JOIN tb_documentos f ON f.iddocumento = (SELECT f1.iddocumento FROM tb_documentos f1 WHERE f1.idpessoa = a.idpessoa AND f1.iddocumentotipo = 1 LIMIT 1) -- CPF
    LEFT JOIN tb_documentos g ON g.iddocumento = (SELECT g1.iddocumento FROM tb_documentos g1 WHERE g1.idpessoa = a.idpessoa AND g1.iddocumentotipo = 2 LIMIT 1) -- CNPJ
    LEFT JOIN tb_documentos h ON h.iddocumento = (SELECT h1.iddocumento FROM tb_documentos h1 WHERE h1.idpessoa = a.idpessoa AND h1.iddocumentotipo = 3 LIMIT 1) -- RG
    LEFT JOIN tb_pessoasvalores j ON j.idcampo = (SELECT j1.idcampo FROM tb_pessoasvalores j1 WHERE j1.idpessoa = a.idpessoa AND j1.idcampo = 1 LIMIT 1) -- SEXO
    LEFT JOIN tb_pessoasvalores k ON k.idcampo = (SELECT k1.idcampo FROM tb_pessoasvalores k1 WHERE k1.idpessoa = a.idpessoa AND k1.idcampo = 2 LIMIT 1) -- DATA DE NASCIMENTO
    LEFT JOIN tb_pessoasvalores o ON o.idcampo = (SELECT o1.idcampo FROM tb_pessoasvalores o1 WHERE o1.idpessoa = a.idpessoa AND o1.idcampo = 3 LIMIT 1) -- FOTO
    LEFT JOIN tb_pessoascategorias l ON a.idpessoa = l.idpessoa AND l.idcategoria = 1 -- CLIENTE
    LEFT JOIN tb_pessoascategorias m ON a.idpessoa = m.idpessoa AND m.idcategoria = 1 -- FORNECEDOR
    LEFT JOIN tb_pessoascategorias n ON a.idpessoa = n.idpessoa AND n.idcategoria = 1 -- COLABORADOR
    WHERE 
            a.idpessoa = pidpessoa 
            AND 
            a.inremovido = 0
    LIMIT 1;

END