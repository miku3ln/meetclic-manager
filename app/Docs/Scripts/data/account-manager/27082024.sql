SET
FOREIGN_KEY_CHECKS=0;

INSERT INTO `types_payments_by_account` (`id`, `accounting_account_id`, `types_payments_id`,
                                                 `business_id`)
VALUES (1, 5, 1, 1),
       (2, 7, 20, 1),
       (3, 285, 20, 1),
       (4, 271, 10, 1),
       (5, 5, 1, 1);

SET
FOREIGN_KEY_CHECKS=1;
COMMIT;

