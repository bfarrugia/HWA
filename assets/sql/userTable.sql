# Create a table 'users' with all basic data
CREATE TABLE users {
    id INT(6) NOT NULL UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    address1 VARCHAR(64) NOT NULL,
    address2 VARCHAR(64) NOT NULL,
    city VARCHAR(30) NOT NULL,
    state VARCHAR(8) NOT NULL,
    zipcode VARCHAR(10) NOT NULL,
    country VARCHAR(8) NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
}