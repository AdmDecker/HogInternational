CREATE TABLE users
(
	userID int NOT NULL AUTO_INCREMENT,
	userName VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
    role CHAR,
	PRIMARY KEY (userID),
);

CREATE TABLE orders
(
    userID int NOT NULL,
    FOREIGN KEY userID references users(userID),
    
    id int NOT NULL AUTO_INCREMENT,
    destination VARCHAR(255),
    pickup VARCHAR(255),
    pickupTime TIME,
    pickupDate DATE,
    oStatus VARCHAR(255),
    statusPercent int,
    price DECIMAL(5,2),
    
    PRIMARY KEY(userID)
);

CREATE TABLE creditCards
(
    ccID int NOT NULL AUTO_INCREMENT,
    customer int NOT NULL,
    FOREIGN KEY(customer) REFERENCES users(userID),
    type VARCHAR(255),
    number CHAR(16),
    expirationDate DATE,
    PRIMARY KEY(ccID)
);

CREATE TABLE drivers
(
    driverID int,
    FOREIGN KEY(driverID) REFERENCES users(UserID),
    salary int NOT NULL,
    hours int NOT NULL,
    
    PRIMARY KEY(driverID)
);
