University Facilities Reservation System

This project is a web-based application for university users to reserve facilities like classrooms, gyms, theatres, workshops, laboratories, or lockers. It's built using the following 

Technologies:

Front-End:
HTML: Defines the structure and content of web pages.
CSS: Styles the visual appearance of the web pages.
JavaScript: Adds interactivity and dynamic behavior to the web pages.
Back-End:
PHP: Processes user requests and interacts with a database to manage reservations.

Features:

Users can browse available facilities with details like capacity and equipment.
An availability view allows users to see the availability of facilities for a chosen date and time.
Users can submit reservation requests with details like duration.
Users can view their submitted reservations.
Users can have access to system announcements in case of conflicts.
Admin account has full control over the system's users, facilities, times, dates and announcements.
Installation:

Server Setup:

This application requires a web server with PHP support. Popular options include Apache used using XAMPP (https://www.apachefriends.org/download.html).
A database server like MySQL (https://www.mysql.com/) is also needed to store facility information and reservation data. 
Database Configuration:
Edit the PHP files to configure the database connection details (hostname, username, password, database name).
File Permissions:
Ensure the web server user has permissions to read and write to the application files and directories.

Usage:

Upload the application files to your web server's document root directory.
Access the application URL in your web browser (http://localhost/facilities-reservation).

Dependencies:

PHP
MySQL database server

Further Development:

Implement user authentication and authorization for secure access.
Integrate an email notification system for reservation confirmations and updates.
Add functionalities for managing recurring reservations.
Develop reports to analyze facility usage trends.
