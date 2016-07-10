CREATE TABLE Users (
  UserID INTEGER CONSTRAINT user_userid_pk PRIMARY KEY,
  password VARCHAR(20) NOT NULL,
  username VARCHAR(20) NOT NULL,
  lastName VARCHAR(20),
  firstName VARCHAR(20),
  email VARCHAR(20),
  postcode VARCHAR(6),
  country VARCHAR(20)
);

CREATE TABLE Profile (
  UserID INTEGER UNIQUE NOT NULL,
  maxAgeRating VARCHAR(10)
    CONSTRAINT profile_maxagerating_check
    CHECK (maxAgeRating IN ('PG', 'PG-13', 'R')),
  yearBorn SMALLINT,
  gender CHAR(1),
  join_date DATE,
  CONSTRAINT profile_gender_check CHECK (gender IN ('M', 'F')),
  FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Topics (
  TopicID INTEGER CONSTRAINT topics_topicid_pk PRIMARY KEY,
  description VARCHAR(10) NOT NULL
);

CREATE TABLE Movie (
  MovieID INTEGER CONSTRAINT movie_movieid_pk PRIMARY KEY,
  name VARCHAR(50) NOT NULL,
  dateReleased DATE,
  countryReleased VARCHAR(20),
  language VARCHAR(20),
  subtitles BOOLEAN
);



CREATE TABLE Actor (
  ActorID INTEGER CONSTRAINT actor_actorid_pk PRIMARY KEY,
  lastName VARCHAR(20) NOT NULL,
  firstName VARCHAR(20) NOT NULL,
  dateOfBirth DATE
);

CREATE TABLE Role (
  RoleID INTEGER CONSTRAINT role_roleid_pk PRIMARY KEY,
  name VARCHAR(20) NOT NULL,
  ActorID INTEGER CONSTRAINT role_actorid_unique UNIQUE,
  MovieID INTEGER,
  FOREIGN KEY (ActorID) REFERENCES Actor(ActorID),
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
  UNIQUE (RoleID, ActorID)
);



CREATE TABLE Director (
  DirectorID INTEGER CONSTRAINT director_directorid_pk PRIMARY KEY,
  lastName VARCHAR(20) NOT NULL,
  firstName VARCHAR(20) NOT NULL,
  country VARCHAR(20)
);

CREATE TABLE Writer (
  WriterID INTEGER CONSTRAINT writer_writerid_pk PRIMARY KEY,
  lastName VARCHAR(20) NOT NULL,
  firstName VARCHAR(20) NOT NULL,
  country VARCHAR(20)
);

CREATE TABLE Writes (
  WriterID INTEGER,
  MovieID INTEGER,
  FOREIGN KEY (WriterID) REFERENCES Writer(WriterID),
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);

CREATE TABLE Studio (
  StudioID INTEGER CONSTRAINT studio_studioid_pk PRIMARY KEY,
  name VARCHAR(20) NOT NULL,
  country VARCHAR(20)
);

CREATE TABLE Watched (
  UserID INTEGER NOT NULL,
  MovieID INTEGER NOT NULL,
  rating SMALLINT CONSTRAINT watched_rating_check CHECK (rating >= 0 AND rating <= 10),
  date DATE,
  FOREIGN KEY (UserID) REFERENCES Users(UserID),
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
  UNIQUE (UserID, MovieID)
);


CREATE TABLE Likes (
  UserID INTEGER,
  TopicID INTEGER,
  FOREIGN KEY (UserID) REFERENCES Users(UserID),
  FOREIGN KEY (TopicID) REFERENCES Topics(TopicID)
);


CREATE TABLE ActorPlays (
  MovieID INTEGER,
  ActorID INTEGER,
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
  FOREIGN KEY (ActorID) REFERENCES Actor(ActorID)
);

CREATE TABLE Directs (
  DirectorID INTEGER,
  MovieID INTEGER,
  FOREIGN KEY (DirectorID) REFERENCES Director(DirectorID),
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);

CREATE TABLE Sponsors (
  StudioID INTEGER,
  MovieID INTEGER,
  FOREIGN KEY (StudioID) REFERENCES Studio(StudioID),
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID)
);

CREATE TABLE MovieTopics (
  MovieID INTEGER,
  TopicID INTEGER,
  FOREIGN KEY (MovieID) REFERENCES Movie(MovieID),
  FOREIGN KEY (TopicID) REFERENCES Topics(TopicID)
);
