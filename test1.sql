SELECT
    `b_prop_value`.*
FROM
    `b_prop_value`
        LEFT OUTER JOIN
    (SELECT MIN(`id`) AS `id`, `CODE`, `VALUE` FROM `table` GROUP BY `CODE`, `VALUE`) AS `tmp`
    ON
            `a`.`id` = `tmp`.`id`
WHERE
    `tmp`.`id` IS NULL