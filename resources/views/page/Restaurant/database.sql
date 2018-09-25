DROP DATABASE IF EXISTS Restaurant;
CREATE DATABASE Restaurant;
USE Restaurant;

CREATE TABLE Orders (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`table_number` INTEGER NOT NULL,
	`complete` BOOLEAN DEFAULT 0,
	PRIMARY KEY (`id`)
);

CREATE TABLE Dishes (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(32) NOT NULL UNIQUE,
	`price` FLOAT(4) NOT NULL,
	`category` VARCHAR(32) NOT NULL,
	`description` VARCHAR(1024) NOT NULL,
	`per_order` INTEGER NOT NULL DEFAULT 1,
	PRIMARY KEY (`id`)
);

CREATE TABLE Ingredients (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(64) NOT NULL UNIQUE,
	`stock` FLOAT(8) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE Order_Dishes (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`order` INTEGER NOT NULL,
	`dish` INTEGER NOT NULL,
	`ready` BOOLEAN DEFAULT 0,
	`comment` VARCHAR(256),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES Orders(`id`),
	FOREIGN KEY (`dish`) REFERENCES Dishes(`id`)
);

CREATE TABLE Dish_Ingredients (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`dish` INTEGER NOT NULL,
	`ingredient` INTEGER NOT NULL,
	`quantity` FLOAT(8),
	PRIMARY KEY (`id`),
	FOREIGN KEY (`dish`) REFERENCES Dishes(`id`),
	FOREIGN KEY (`ingredient`) REFERENCES Ingredients(`id`)
);

CREATE TABLE Order_Dish_Ingredients (
	`id` INTEGER NOT NULL AUTO_INCREMENT,
	`order` INTEGER NOT NULL,
	`dish_ingredient` INTEGER NOT NULL,
	`change` ENUM("More","Default","Less","None") NOT NULL DEFAULT "Default",
	PRIMARY KEY (`id`),
	FOREIGN KEY (`order`) REFERENCES Orders(`id`),
	FOREIGN KEY (`dish_ingredient`) REFERENCES Dish_Ingredients(`id`)
);

INSERT INTO Dishes 
(name, per_order, price, category, description) 
VALUES 
("Large Special Fried Rice", 1, 6.30, "Sides", ""),
("Sweet And Sour Pork", 1, 11.20, "Mains", ""),
("Beef Spare Ribs", 1, 12.00, "Mains", ""),
("Short Soup", 1, 10.50, "Mains", ""),
("Spring Rolls", 5, 5.00, "Sides", "");

INSERT INTO Ingredients
(id, name, stock)
VALUES
(1,"Rice",500.00),
(2,"Chicken",500.00),
(3,"Coconut Cream",500.00),
(4,"Soy Sauce",500.00),
(5,"Prawn",500.00),
(6,"Satay Sauce",500.00),
(7,"Ham",500.00),
(8,"Green Capsicum",500.00),
(9,"Red Capsicum",500.00),
(10,"Beef",500.00),
(11,"Pork",500.00),
(12,"Spring Roll",500.00),
(13,"Soup",500.00),
(14,"Sweet And Sour Sauce",500.00),
(15,"Olive Oil",500.00);

INSERT INTO Dish_Ingredients
(dish, ingredient, quantity)
VALUES
(1,1,0.50),
(1,2,0.20),
(1,3,0.45),
(1,4,0.10),
(1,5,0.25),
(1,7,0.15),
(1,8,0.20),
(2,14,0.35),
(2,11,0.40),
(2,15,0.05),
(2,1,0.50),
(2,3,0.15),
(3,1,0.50),
(3,1,0.40),
(3,4,0.10),
(3,15,0.05),
(4,13,0.30),
(5,12,1.0);