# Agriculture product usage in industry, medicine and research

In this project I used mysql primarily for data storgae, data retrieving and data manipulation. Php, HTML and CSS were the main programming languages that supported connection with apache server and to
connect database. 

Medicine purpose stores data and it has data that is already stored. Medicine purpose takes 
 id INT(11) AUTO_INCREMENT PRIMARY KEY, VARCHAR(100) NOT NULL, VARCHAR(100) NOT NULL,TEXT NOT NULL.

 Same goes to other php files except they have a little differences, for example environment damage php only takes files along with the description of files and personal info, as well as stores the data.
 Although user has to download the file to see what is in it. Unlike the two above industry php file doesn't store any information from the user, it has options to search the available data and to see 
 all the data that is displayed on the main page. It allows only the owner of the program and the server to store the data inside apache mysql using the command such as INSERT INTO TABLE_NAME(...)
 VALUES('',''...);

 All of the tables above are inside the agriculture_products database. to store the data, USE database_name is used to select the suitable database and store or create a table.

 # Index php

 This php table is main reference page for the rest. It links other pages using   " <button onclick="location.href='medical_purpose.php'">Medical Purpose</button> "
 
