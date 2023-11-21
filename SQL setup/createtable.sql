CREATE TABLE users(
    userID varchar(155),
    roles varchar(15),
    username varchar(50),
    email varchar(100),
    password varchar(255),
    date datetime
)

CREATE TABLE usession(
    SID varchar(115),
    userID varchar(155),
    sessionID varchar(155),
    expdate int
)