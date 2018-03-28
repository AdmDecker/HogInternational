CREATE TABLE users
(
	userID int NOT NULL AUTO_INCREMENT,
	userName VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
    role CHAR NOT NULL CHECK(IN('R', 'D', 'M')),
	PRIMARY KEY (userID),
    CONSTRAINT roleConstraint role 
);

CREATE TABLE orders
(
    id int NOT NULL AUTO_INCREMENT,
    destination VARCHAR(255),
    pickup VARCHAR(255),
    pickupTime TIME,
    pickupDate DATE,
    oStatus VARCHAR(255),
    statusPercent int CHECK(BETWEEN(0, 100))
);

CREATE TABLE creditCards
(
    customer int NOT NULL,
    FOREIGN KEY(customer) REFERENCES users(userID),
    type VARCHAR(255),
    number CHAR(16),
    expirationDate DATE
);

CREATE TABLE drivers
(
    driverID int,
    FOREIGN KEY(driverID) REFERENCES users(UserID),
    salary int NOT NULL,
    hours int NOT NULL
);
