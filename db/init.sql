CREATE TABLE IF NOT EXISTS users (
    id       INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    balance  DECIMAL(10,2) DEFAULT 1000.00
);

INSERT INTO users (username, password, balance) VALUES
    ('alice', 'password123', 5000.00),
    ('bob',   'qwerty',      2500.00),
    ('admin', 'admin',       99999.00);