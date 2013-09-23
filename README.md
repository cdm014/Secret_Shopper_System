Secret_Shopper_System
=====================
##To Do##
* [] add question editor function to manager controller
* [] add quiz editor function to manager controller
* [] add quiz selection function to shopper controller


##Updated 2013-09-23##
The addition of two more tables to the database will allow quizzes to be created from the management interface rather than as views.
* quizzes will store the names and id numbers of the quizzes
* quiz_questions is where the questions for the individual quizzes are set up it stores quiz number, question code, and order to the questions for that quiz.

##Original ##

built on CodeIgniter to allow library to manage and survey secret shoppers.
Requires a database named 'secret_shopper' with 4 tables

* questions
* q_answers
* reviews
* shoppers

questions table
The questions table is used to store the questions the secret shoppers will be asked. 
* code varchar(30) not null <- used as the primary key, and will be the actual field name for the forms.
* type enum('text','dropdown','checkbox','radio buton','yes_no') <- type of question used only when we need to know if there's a specific set of answers
* text tinytext <- text of the question

q_answers table
used to store all possible answers for questions where that matters
* code varchar(30) not null [this is equal to 'code' on the questions table] <- what question is this a possible answer for
* order tinyint(11) <- if it matters then this is the order the questions should be displayed in (0 = first, 1 = second, etc...)
* sval varchar(30) <- this will be the value passed by the form
* dval text <- used as the display value for drop downs, radio buttons, and checkboxes

reviews table
used to store actual secret shopper responses
* answer text <- what their answer to the question was 
* branch varchar(3) <- what branch they were reviewing
* date char(20) <- when they visited the branch
* question varchar(30) [questions `code`] <- what question this answer goes to
* ss_id int(11) <- Their secret shopper code
* time varchar(20) <- what time they visited the branch

shoppers table
used to store information on the secret shoppers
* id int(11) [reviews `ss_id`] <- their secret shopper code (how they login to the system and the only identifying information stored alongside their answer)
* name tinytext 
* email tinytext
* phone tinytext
* branches tinytext
