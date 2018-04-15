CREATE TABLE users
(
	userID int NOT NULL AUTO_INCREMENT,
	userName VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
    role CHAR,
	PRIMARY KEY (userID)
);

CREATE TABLE creditCards
(
    ccID int NOT NULL AUTO_INCREMENT,
    customer int NOT NULL,
    FOREIGN KEY (customer) REFERENCES users(userID),
    type VARCHAR(255),
    number CHAR(16),
    expirationDate DATE,
    PRIMARY KEY(ccID)
);

CREATE TABLE busses
(
    busID int NOT NULL AUTO_INCREMENT,
    handicap BOOL NOT NULL
)

CREATE TABLE drivers
(
    driverID int,
    FOREIGN KEY(driverID) REFERENCES users(UserID),
    salary int NOT NULL,
    hours int NOT NULL,
    assignedBus int,
    FOREIGN KEY assignedBus REFERENCES busses(busID),
    PRIMARY KEY(driverID)
);

CREATE TABLE orders
(
    userID int NOT NULL,
    FOREIGN KEY (userID) references users(userID),
    orderID int NOT NULL AUTO_INCREMENT,
    destination VARCHAR(255),
    pickup VARCHAR(255),
    travelTime int,
    pickupDate VARCHAR(255),
    oStatus VARCHAR(255),
    statusPercent int,
    price DECIMAL(5,2),
    headCount int,
    handicap BOOL,
    distance DECIMAL(5, 2),
    paymentMethod VARCHAR(255),
    assignedBus int,
    pickupDateDT DATETIME,
    depotTime int,
    returnDateDT DATETIME,
    FOREIGN KEY(assignedBus) REFERENCES busses(busID),
    PRIMARY KEY(orderID)
);


/*test data*/
INSERT INTO users VALUES(1337, "TestCustomer", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "C");
INSERT INTO users VALUES(1338, "TestDriver", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "D");
INSERT INTO drivers VALUES(1338, 10000, 40);
INSERT INTO users VALUES(1339, "TestManager", "$2y$10$YhcXJOg.Y2KwOAd5MrZZX.qlWlvRql8xn50cbVotU9lajyhp1qNsS", "M");

INSERT INTO busses(NULL, 0);
INSERT INTO busses(NULL, 1);
INSERT INTO orders VALUES(1337, NULL, "The Void", "Earth", '12:14:16', '2018-04-27', "Pending", 0, 32.75);
