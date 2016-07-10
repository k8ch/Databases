/*
  a. Display all the information about a user-specified movie. That is, the user should select the
    name of the movie from a list, and the information as contained in the movie table should then
  be displayed on the screen.
*/

SELECT *
FROM Movie as M
WHERE M.Name = 'The Shawshank Redemption';

/*
  b. Display the full list of actors, and their roles, of a specific movie. That is, the user should select
  the name of the movie from a list, and all the details of the actors, together with their roles,
  should be displayed on the screen.   
*/

SELECT A.*, R.Name
FROM Actor as A
INNER JOIN Actorplays AS AP USING (ActorID)
INNER JOIN Role AS R USING (ActorID)
INNER JOIN Movie AS M USING (MovieID)
WHERE M.Name = 'The Shawshank Redemption';


/* Update Role table to include movieid */

/*
  c. For each user-specified category of movie, list the details of the director(s) and studio(s),
  together with the date that the movie has been released. The user should be able to select the
  category (e.g. Horror or Nature) from a list
*/

SELECT D.FirstName, D.LastName, S.Name, M.DateReleased
FROM Director AS D
INNER JOIN Directs AS DR USING (DirectorID)
INNER JOIN Sponsors AS SS USING (MovieID)
INNER JOIN Studio AS S USING (StudioID)
INNER JOIN Movie AS M USING (MovieID)
INNER JOIN MovieTopics AS MT USING (MovieID)
INNER JOIN Topics AS T USING (TopicID)
WHERE T.Description = 'Crime';

/*
  d. Display the information about the actor that appeared the most often in the movies, as
  contained in your database. Display this information together with the details of the director(s)
  and the studio(s) that s(he) worked with. DONE
*/
/*
SELECT *
FROM Actor AS A
INNER JOIN ActorPlays as AP USING (ActorID)
WHERE ActorID IN (SELECT max(count(A.actorid)) from ActorPlays AS AP);
*/
/*
  f. Find the names of the ten movies with the highest overall ratings in your database. DONE
*/

SELECT Ratings.Name
FROM (
       SELECT W.MovieID, M.Name, CAST(AVG(W.Rating) AS INTEGER)
       FROM Watched AS W
         INNER JOIN Movie AS M USING (MovieID)
       WHERE W.rating NOTNULL
       GROUP BY W.MovieID, M.Name
       ORDER BY AVG(W.Rating) DESC
       LIMIT 10
     ) AS Ratings;

/*
  g. Find the movie(s) with the highest overall rating in your database. Display all the movie details,
  together with the topics (tags) associated with it.
*/

SELECT M.*, T.description
FROM Topics AS T
INNER JOIN MovieTopics AS MT USING(TopicID)
INNER JOIN Movie AS M USING (MovieID)
WHERE M.Name IN (
  SELECT  Ratings.Name FROM (
    SELECT W.MovieID, M.Name, CAST(AVG(W.Rating) AS INTEGER)
    FROM Watched AS W
    INNER JOIN Movie AS M USING (MovieID)
    WHERE W.rating NOTNULL
          AND W.rating IN (
      SELECT MAX(W.rating) FROM Watched AS W)
    GROUP BY W.MovieID, M.Name
    ORDER BY AVG(W.Rating) DESC
  ) AS Ratings
);

/*
  h. Find the total number of rating for each movie, for each user. That is, the data should be
  grouped by the movie, the specific users and the numeric ratings they have received.
 */
/*
SELECT M.Name, U.username, W.rating
FROM Movie AS M
INNER JOIN Watched AS W USING (MovieID)
INNER JOIN Users AS U USING (UserID)
WHERE W.Rating NOTNULL
GROUP BY M.Name, U.username, W.Rating
ORDER BY M.Name, W.Rating DESC;
*/
/*
  i. Display the details of the movies that have not been rated since January 2016.
*/
/*
SELECT *
FROM Movie AS M
WHERE M.MovieID NOT IN (
  SELECT M.MovieID
  FROM Movie AS M
  INNER JOIN Watched AS W USING (MovieID)
  WHERE W.Date > '2016-01-01'
);
*/
/*
  j. Find the names, release dates and the names of the directors of the movies that obtained rating
  that is lower than any rating given by user X. Order your results by the dates of the ratings.
  (Here, X refers to any user of your choice.)
 */
/*
SELECT M.Name, M.DateReleased, D.FirstName, D.LastName
FROM Movie AS M
INNER JOIN Watched AS W USING (MovieID)
INNER JOIN Directs AS DS ON (M.MovieID = DS.MovieID)
INNER JOIN Director AS D USING (DirectorID)
WHERE W.Rating < ANY (
  SELECT W.Rating
  FROM Watched AS W
  WHERE W.UserID = 5
)
ORDER BY W.Date DESC;
*/
/*
  k. List the details of the Type Y movie that obtained the highest rating. Display the movie name
  together with the name(s) of the rater(s) who gave these ratings. (Here, Type Y refers to any
  movie type of your choice, e.g. Horror or Romance.)  
 */
/*
SELECT M.Name, W.UserID
FROM Movie AS M
INNER JOIN Watched AS W USING (MovieID)
WHERE W.Rating IN (
  SELECT MAX(W.Rating) FROM Watched AS W)
AND M.Name IN (
  SELECT Ratings.Name FROM (
    SELECT M.Name, MAX(W.Rating)
    FROM Movie AS M
    INNER JOIN Watched AS W USING (MovieID)
    INNER JOIN MovieTopics AS MT USING (MovieID)
    INNER JOIN Topics AS T USING (TopicID)
    WHERE T.Description = 'Crime'
    GROUP BY M.Name
  ) AS Ratings
);
*/
/*
  l. Provide a query to determine whether Type Y movies are “more popular” than other movies.  
  (Here, Type Y refers to any movie type of your choice, e.g. Nature.) Yes, this query is open to
  your own interpretation!
 */
/*
/*
  Version 1: Using average ratings per topic
*/
SELECT T.Description, CAST(AVG(W.Rating) AS INTEGER) AS AVG_Rating
FROM Topics AS T
INNER JOIN MovieTopics AS MT USING (TopicID)
INNER JOIN Watched AS W USING (MovieID)
WHERE W.Rating NOTNULL
GROUP BY T.Description
ORDER BY AVG_Rating DESC;

/*
  Version 2: Total likes per topic
*/
SELECT T.Description, COUNT(L.TopicID) AS Total_Likes
FROM Topics AS T
INNER JOIN Likes AS L USING (TopicID)
WHERE L.TopicID NOTNULL
GROUP BY T.Description
ORDER BY Total_Likes DESC;

/**/
  m. Find the names, join-date and profiling information (age-range, gender, and so on) of the users
  that give the highest overall ratings. Display this information together with the names of the
  movies and the dates the ratings were done.
*/
/*
SELECT U.FirstName, U.LastName, P.*, M.Name, W.Date
FROM Users AS U
INNER JOIN Profile AS P USING (UserID)
INNER JOIN Watched AS W USING (UserID)
INNER JOIN Movie AS M USING (MovieID)
WHERE W.Rating IN (
  SELECT MAX(W.Rating)
  FROM Watched AS W
);
*/
/*
  o. Find the names and emails of all users who gave ratings that are lower than that of a rater with
  a name called John Smith. (Note that there may be more than one rater with this name).
*/
/*
SELECT DISTINCT U.FirstName, U.LastName, U.Email
FROM Users AS U
INNER JOIN Watched AS W USING (UserID)
WHERE W.Rating < ANY (
  SELECT W.Rating
  FROM Watched AS W
  INNER JOIN Users USING (UserID)
  WHERE U.UserName = 'John Smith'
);
*/
/*
  p. Find the names and emails of the users that provide the most diverse ratings within a specific
  genre. Display this information together with the movie names and the ratings. For example,
  Jane Doe may have rated terminator 1 as a 1, Terminator 2 as a 10 and Terminator 3 as a 3.  
  Clearly, she changes her mind quite often!
 */
/*
SELECT U.FirstName, U.LastName, U.Email, M.Name, W.Rating
FROM Users AS U
INNER JOIN Watched AS W USING (UserID)
INNER JOIN Movie AS M USING (MovieID)
INNER JOIN MovieTopics AS MT USING (MovieID)
INNER JOIN Topics AS T USING (TopicID)
WHERE W.UserID IN (
  SELECT W.UserID
  FROM Watched AS W
  INNER JOIN MovieTopics AS MT USING (MovieID)
  INNER JOIN Topics AS T USING (TopicID)
  WHERE W.Rating > 7
  AND T.Description = 'Drama'
)
AND W.UserID IN (
  SELECT W.UserID
  FROM Watched AS W
  INNER JOIN MovieTopics AS MT USING (MovieID)
  INNER JOIN Topics AS T USING (TopicID)
  WHERE W.Rating < 3
  AND T.Description = 'Drama'
);*/


SELECT M.name, T.description
from movie as M
INNER JOIN movietopics as MT using (movieid)
INNER JOIN topics as T using (topicid)
where T.description='Crime'
;

SELECT T.description from topics as t;



SELECT M.MovieID, M.Name, M.DateReleased, CAST(AVG(W.Rating) AS INTEGER)
FROM Movie AS M
  INNER JOIN Watched AS W USING (MovieID)
  INNER JOIN MovieTopics AS MT USING (MovieID)
  INNER JOIN Topics AS T USING (TopicID)
  GROUP BY M.movieid, M.name, M.datereleased
ORDER BY M.Name;

SELECT T.description
FROM Topics AS T
INNER JOIN MovieTopics AS MT USING (TopicID)
INNER JOIN Movie AS M USING (MovieID)
WHERE M.MovieID = '';


SELECT M.MovieID, M.Name, D.firstname, D.lastname, M.DateReleased, ROUND(AVG(W.Rating), 1)
FROM Movie AS M
  INNER JOIN Watched AS W USING (MovieID)
  INNER JOIN MovieTopics AS MT USING (MovieID)
  INNER JOIN Topics AS T USING (TopicID)
  INNER JOIN Directs AS DS USING (MovieID)
  INNER JOIN Director AS D USING (DirectorID)
GROUP BY M.movieid, M.name, D.firstname, D.lastname, M.datereleased
ORDER BY M.Name;


