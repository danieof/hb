INSERT INTO `account_type` (`ID`, `typename`) VALUES
(1, 'asset'),
(2, 'liability'),
(3, 'equity'),
(4, 'income'),
(5, 'expense');

INSERT INTO `account_subtype` (`subtypename`, `parent_type_id`) VALUES
('cash', 1),
('bank', 1),
('stock', 1),
('mutualfund', 1),
('receivable', 1),
('asset', 1),
('creditcard', 2),
('payable', 2),
('liability', 2),
('equity', 3),
('income', 4),
('expense', 5)