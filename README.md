# Message board

A simple web application where users can create an account and post messages and read messages posted by other users. Similar to a discussion forum.

# Main features
    * User login
    * User registration
    * Post messages
    * View messages posted by other users
    * Logout
    
# Database
    Sqlite3
    Schema:
        - users
            * username   varchar(10) primary key
            * password   varchar(32)
            * fullname   varchar(45)
            * email      varchar(45)
            
        - posts
            * id         varchar(13) primary key
            * postedby   varchar(10)
            * datetime   datetime
            * message    text
            
# Webapp link

http://omega.uta.edu/~sxa1001/shreyasanand/post/board.php