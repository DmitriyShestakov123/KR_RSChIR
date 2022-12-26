CREATE DATABASE IF NOT EXISTS appDB;
CREATE USER IF NOT EXISTS 'user'@'%' IDENTIFIED BY 'password';
GRANT SELECT,UPDATE,INSERT ON appDB.* TO 'user'@'%';



USE appDB;
ALTER DATABASE appDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS accounts(
	acc_id INTEGER NOT NULL PRIMARY KEY AUTO_INCREMENT,
  	username VARCHAR(50) NOT NULL,
  	passwords VARCHAR(50) NOT NULL,
  	email VARCHAR(100) NOT NULL,
    administrator TINYINT(1)
);


INSERT INTO accounts (username, passwords, email, administrator) VALUES ('admin', 'admin', 'test@test.com', 1);
INSERT INTO accounts (username, passwords, email) VALUES ('user1', 'admin', 'address1@test.com');
INSERT INTO accounts (username, passwords, email) VALUES ('user2', 'admin', 'address2@test.com');


CREATE TABLE IF NOT EXISTS survey_questions(
    surveyName VARCHAR(100),
    idSurvey INTEGER,
    idQuestion INTEGER AUTO_INCREMENT,
    questionBody VARCHAR(100),
    PRIMARY KEY(idQuestion)
);
CREATE TABLE IF NOT EXISTS survey_answers(
    idSurvey INTEGER,
    idQuestion INTEGER,
    answer1 INTEGER DEFAULT 0,
    answer2 INTEGER DEFAULT 0,
    answer3 INTEGER DEFAULT 0,
    answer4 INTEGER DEFAULT 0,
    answer5 INTEGER DEFAULT 0,
    FOREIGN KEY (idQuestion) REFERENCES survey_questions(idQuestion)
);

CREATE TABLE IF NOT EXISTS completed_surveys(
    username VARCHAR(50) NOT NULL,
    idSurvey INTEGER,
    surveyName VARCHAR(100)
);

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оценка работы учебного коллектива', 1, N'Насколько вы оцениваете общую подготовку?');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (1, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оценка работы учебного коллектива', 1, N'Насколько вы оцениваете что-нибудь?');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (1, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оценка работы учебного коллектива', 1, N'Оцените качество обучения');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (1, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оценка работы учебного коллектива', 1, N'Оцените техническое обеспечение обучения');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (1, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оценка работы учебного коллектива', 1, N'Оцените материальное обеспечение обучения');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (1, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оцените', 2, N'Оцените');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (2, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Оцените', 2, N'Оцените другое');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (2, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Форма для заполнения', 3, N'Насколько вы были довольны сервисом?');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (3, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));

INSERT INTO survey_questions(surveyName, idSurvey, questionBody) VALUES (N'Форма для заполнения', 3, N'Каковы ваши общие впечатления?');
INSERT INTO survey_answers(idSurvey, idQuestion) VALUES (3, (SELECT idQuestion FROM survey_questions ORDER BY idQuestion DESC LIMIT 1));