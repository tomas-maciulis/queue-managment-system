## About

This project is my take on NFQ software engineering internship task. It is not meant to be developed further than it currently is.


## Usage information

### Users
There are 3 types of users:
-Specialist - can receive reservations and change their statuses
-Guests - can create reservations and cancel them
-Display - can access the queue display

By default, the database is populated with 2 specialists:
-jane.doe@example.net : password
-john.doe@example.net : password

Also, there is 1 display user:
-display@example.net : password

### Creating reservations
When accessing the website, guest user will automatically be redirected to reservation creation page. Only active specialists will be available for selection. After creating a reservation, guest user is redirected to reservation display page which is populated with relevant data. Guest can cancel the reservation within this page, too. All guest accessible pages are optimized for smartphones since they will most likely be accessed using this medium.

### Managing reservations
Once specialist user is authenticated, she is redirected to personal dashboard. The dashboard contains a table with all active reservations (received or in progress) that belong to current user with ability to begin/cancel received reservations and finish ongoing reservation.

### Accessing display
Only display users can access the display. Once display user is authenticated, he is redirected to display dashboard that contains a button to show the display.
