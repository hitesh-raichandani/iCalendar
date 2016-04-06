# iCalendar

Introduction

This project provides a foundation for a website that allows people
to synchronize their calendars with their peers and coworkers.

——

Setup

The website uses PHP and a MySql database. There are two files
that need to be changed in order to run this on a personal
database. These files are listed below

  mysql_connect.php
  
  setup_db.php

These folders contain server information that has to be modified
to suit the server that will be used. The following variables
may have to be changed

  $servername: the server that the website will be run on
  
  $username: the username of a user that has create, insert, and
	     modify permissions on the database
	     
  $password: the password corresponding to the specified username

Once these values have been changed in both of the two files, the
database can be setup by navigating to the home page of the website.
Upon navigation, the database will be set up and able to be used.

——

Basic Usage

Upon navigating to the homepage, the user has two options: log in and
register. These two buttons are located at the top right. A new user
must first register. To register, they must fill out the registration
form that is presented upon pressing the register button. The user must
fill out the registration form to continue. The input values are
validated upon submission through Javascript. If the log in is
successful, the user is then presented with the log in dialog which
they can use to log in with their newly created information.

After logging in, the user is taken to the dashboard. Here, they can
see their calendar for that specific day. Events can be created on this
calendar for that day by clicking and dragging to create an event. The
event can be given a name and will be saved upon hitting Enter.

The inbox is located as the first item on the left navigation bar. This
navigation bar only exists when on the Dashboard or other pages that are
on the left navigation bar. The inbox contains notifications of activity
performed by the user. It will contain a welcome notification indicating
the creation of the account, as well as notifications for added events
and profile edits. In the future, we plan to expand the sources of
notifications and allow for updates across different accounts.

The next link navigates to the users profile page. Here, a profile picture
can be uploaded and user information can be edited. A workplace and position
can both be added. Upon making any changes to the profile information, the
Update button will cause the changes to be submitted.

The support page gives the user a way to email the website admin. There
are input fields for name, subject, and message text. The name will be
automatically filled out with the users name, but this can be changed
in order to submit anonymously. The submit button will open up the
machine’s default email application and compose and email with the fields
filled out.

The logout button is the final link on the left navigation bar. This button
will clear the stored user session and return to the home page.

Along the top navigation bar, there is a link to the dashboard, which will
bring the user to the initial dashboard. Next to this, there is a link to the
schedule. Here, the user can see any events that they had created. The
calendar will default to display the current week. The display can be modified
using the buttons at the top left, and the arrows at the top right. Events
can be added to the user’s calendar by clicking the start time, dragging to the
end time, and filling in a name for the event.

Also accessible through this page, is the group calendar. This calendar can be
accessed by clicking the Group button at the top of the calendar. If the user
selected a workplace on their profile page, then the calendars of everyone in
the selected workplace will show here. If they had not selected a workplace, then
the calendars of the other users who had not selected a workplace will show up.

The next link along the top navigation bar is the search functionality. The page
allows the user to find other users within their workplace that are free on a given
day during a specified time. A day and time range must be selected and then the search
button should be clicked. A search results page will show up that displays all of the
users in the current user’s workplace that are free during that time. Note: this has
been shown to not function properly on some systems and may return all of the users
in the workplace.

The next, and final page on the top navigation bar is the coworkers page. This page
allows the user to see all of the coworkers that exist in the current user’s
workplace. There is a header that specifies the workplace in question and an expanding list that shows all of the users.
