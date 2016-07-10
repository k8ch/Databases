--SET search_path="Assignment2";
/*
Kateryna Chernega 
 Given database schema.sql complete the questions below */

/* QUESTION 1

--The balance of a customer may not be less than 0 or exceed his credit limit; the default value is 100.
ALTER TABLE CUSTOMER ALTER COLUMN balance SET DEFAULT 100.00
ALTER TABLE CUSTOMER ADD CHECK (balance >= 0)

-- The class in the part table has to be one of the following: AP, HW, SG.
ALTER TABLE PART ADD CHECK (class IN ('AP', 'HW', 'SG'))

--The order number and part number in the order line table may not be empty
ALTER TABLE ORDER_LINE ALTER COLUMN order_num SET NOT NULL;
ALTER TABLE ORDER_LINE ALTER COLUMN part_num SET NOT NULL;
*/

/*QUESTION 2
--List the number and name of all the customers not represented by Kaiser Valerie (Rep num 20). 

SELECT C.customer_num, C.customer_name 
	FROM CUSTOMER C, REP R 
	WHERE R.last_name != 'Kaiser' 
		AND R.first_name != 'Valerie' 
		AND R.rep_num = C.rep_num
*/

/*QUESTION 3
-- List the number and name of all sales representatives, along with the number of customers they represent. 

SELECT R.first_name, R.rep_num, COUNT(C.customer_num) 
	FROM REP R, CUSTOMER C 
	WHERE C.rep_num = R.rep_num 
	GROUP BY R.first_name, R.rep_num
*/

/*QUESTION 4
--List the number, name, balance and sales representative number of those customers whose balance is larger than
the balance of at least one customer of Juan Perez (Rep num 65).

SELECT C.customer_num, C.customer_name, C.balance, C.rep_num 
	FROM CUSTOMER C 
	WHERE C.balance > ANY (
		SELECT C2.balance 
		FROM CUSTOMER C2, REP R 
		WHERE C2.rep_num = R.rep_num 
			AND R.first_name = 'Juan')
*/

/*QUESTION 5
--List the order numbers and dates of all orders that contain a Gas Range and were sold by Juan Perez.

SELECT O.order_num, O.order_date 
	FROM ORDERS O, PART P, REP R, ORDER_LINE ORD, CUSTOMER C 
	WHERE P.description = 'Gas Range' 
		AND R.first_name = 'Juan' 
		AND R.last_name = 'Perez' 
		AND P.part_num = ORD.part_num 
		AND ORD.order_num = O.order_num 
		AND O.customer_num = C.customer_num 
		AND C.rep_num = R.rep_num
*/

/*QUESTION 6
--List the number, names and balances of all customers whose credit limit is equal to the largest credit limit awarded
to a customer of Richard Hull (Rep num 35). 
 
SELECT C.customer_num, C.customer_name, C.balance 
	FROM CUSTOMER C 
	WHERE C.credit_limit = ALL (
		SELECT MAX(C2.credit_limit) 
		FROM CUSTOMER C2 
		WHERE C2.rep_num = '65')
*/

/*QUESTION 7
--List the sales representative numbers and names, along with the total amount sold, of all the parts within the AP
class.
SELECT R.rep_num, R.last_name, R.first_name, SUM(OL.quoted_price) 
	FROM REP R, PART P, ORDER_LINE OL, ORDERS O, CUSTOMER C 
	WHERE P.class = 'AP' AND P.part_num = OL.part_num 
		AND OL.order_num = O.order_num 
		AND O.customer_num = C.customer_num 
		AND C.rep_num = R.rep_num 
		GROUP BY R.rep_num, R.last_name, R.first_name */


/*QUESTION 8 
--List each credit limit held by less than two customers, together with the number of customers of Richard Hull (rep
num 35) who have this limit. 
SELECT C.credit_limit, COUNT(C.customer_name) 
	FROM CUSTOMER C
	WHERE C.rep_num = '35'
	GROUP BY C.credit_limit
	HAVING count(*) < 2 */


/*QUESTION 9
--Find the descriptions of all parts included in order 21610.
SELECT P.description 
	FROM PART P, ORDER_LINE OL 
	WHERE OL.order_num = '21610' 
		AND OL.part_num = P.part_num
*/

/*QUESTION 10
--List the customer numbers, customer names and balances, together with their sales representative number, of those
customers who have a remaining credit that is less than the 15% of their credit limit.
SELECT C.customer_num, C.customer_name, C.balance, C.rep_num 
	FROM Customer C 
	WHERE C.balance < (C.credit_limit*0.15)
*/

/*QUESTION 11
--List the customer numbers, customer names and balances of all the customers of Kaiser Valerie who never placed
any orders. 
SELECT C.customer_num, C.customer_name, C.balance 
	FROM CUSTOMER C, REP R WHERE R.last_name = 'Kaiser' 
		AND R.first_name = 'Valerie' 
		AND R.rep_num = C.rep_num 
		AND C.customer_num
		NOT IN(SELECT customer_num FROM ORDERS)
*/

/*QUESTION 12 
--Remove all the information about customer number 408 from the database. 

 
DELETE FROM ORDER_LINE OL
	USING CUSTOMER C, ORDERS O
	WHERE C.customer_num = O.customer_num AND OL.order_num = O.order_num AND C.customer_num = '408'; 
DELETE FROM ORDERS O
	USING CUSTOMER C
	WHERE C.customer_num = O.customer_num AND C.customer_num = '408'; 
DELETE FROM CUSTOMER C 
	WHERE C.customer_num = '408'  */