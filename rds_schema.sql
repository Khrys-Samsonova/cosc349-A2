use assignment2Db;

create table meals(
meal_id int auto_increment, 
meal_name varchar(64), 
meal_description varchar(256),
primary key(meal_id)
);

INSERT INTO meals (meal_name, meal_description) VALUES ('Stew', 'Vege Stew');
INSERT INTO meals (meal_name, meal_description) VALUES ('Green Curry', 'Thai Seafood Curry');
INSERT INTO meals (meal_name, meal_description) VALUES ('Cake', 'Chocolate Cake');
INSERT INTO meals (meal_name, meal_description) VALUES ('Sushi', 'Salmon, Avocado Sushi');

select * from meals;