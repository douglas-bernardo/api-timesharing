SELECT
    u.nomeusuario,
    p.idcliente,
    m.descricao,
    o.observacao,
    o.dataobservacao,
    p.idposvendats AS idposvendats,
    o.numobsposvendats,
    1 AS tipo,
    o.idmotivots,
    o.idusuario,
    TO_CHAR(o.dataobservacao, 'YYYY')|| TO_CHAR(o.dataobservacao, 'MM')|| lpad(o.idposvendats, 8, 0)|| TO_CHAR(o.numobsposvendats) AS protocolo,
    p.idvendaxcontrato,
    (
        SELECT
            dataobservacao
        FROM
            obsposvendats
        WHERE NUMOBSPOSVENDATS = 1
            AND idposvendats = o.idposvendats
    ) AS DATAORDEM,
    ' ' AS nomeusuarioresp,
    (
        SELECT
            TO_CHAR(to_number(pr.numeroprojeto))
            || '-'
            || TO_CHAR(to_number(vc.numerocontrato)) AS numerocontrato
        FROM
            vendaxcontratots   vc,
            contratots         c,
            projetots          pr
        WHERE
            vc.idcontratots = c.idcontratots
            AND vc.idprojetots = pr.idprojetots
            AND vc.idvendaxcontrato = p.idvendaxcontrato
    ) numerocontrato
FROM
    posvendats       p,
    obsposvendats    o,
    usuariosistema   u,
    motivots         m
WHERE
    p.idposvendats = o.idposvendats
    AND u.idusuario = o.idusuario
    AND o.idmotivots = m.idmotivots (+)