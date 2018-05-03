# MaterialOs--Theme-for-OsTicket-v1.10.1
MaterialOs- Theme with Material Kit for helpmeplease.co.za

# Status
- Currently Under Construction

# osTicket
osTicket extension for Live Helper Chat
https://livehelperchat.com/osticket-extension-394a.html

# Working
- Responsive adaptation
- General adaptation of each section

# How this works for you
students create tickets via your website, email, or phone
Incoming tickets are saved and assigned to tutors
tutors help your students resolve their issues

# Requirements
HTTP server running Microsoft® IIS or Apache
PHP version 5.4 or greater, 5.6 is recommended
mysqli extension for PHP
MySQL database version 5.0 or greater
Recommendations
gd, gettext, imap, json, mbstring, and xml extensions for PHP
APC module enabled and configured for PHP

# Deployment
The easiest way to install the software and track updates is to clone the public repository. Create a folder on you web server (using whatever method makes sense for you) and cd into it. Then clone the repository (the folder must be empty!):

git clone https://github.com/waldonhendricks/helpmeplease.co.za
And deploy the code into somewhere in your server's www root folder, for instance

cd osTicket
php manage.php deploy --setup /var/www/html/web/
Then you can configure your server if necessary to serve that folder, and visit the page and install osTicket as usual. Go ahead and even delete setup/ folder out of the deployment location when you’re finished. Then, later, you can fetch updates and deploy them (from the folder where you cloned the git repo into)

git pull
php manage.php deploy -v /var/www/html/web/

# Documentation
http://livehelperchat.com/documentation-6c.html

# Extensions
https://github.com/LiveHelperChat

# Translations contribution
https://www.transifex.com/projects/p/live-helper-chat/

Folders structure
Directories content:
lhc_web - WEB application folder.

# Rest API support
https://api.livehelperchat.com/

# Third party support
Telegram
Twilio
Facebook messenger
Features
Few main features

XMPP support for notifications about new chats. (IPhone, IPad, Android, Blackberry, GTalk etc...)
Chrome extension
Repeatable sound notifications
Work hours
See what user see with screenshot feature
Drag & Drop widgets, minimize/maximize widgets
Multiple chats same time
See what users are typing before they send a message
Multiple operators
Send delayed canned messages as it was real user typing
Chats archive
Priority queue
Chats statistic generation, top chats
Resume chat after user closed chat
All chats in single window with tabs interface, tabs are remembered before they are closed
Chat transcript print
Chat transcript send by mail
Site widget
Page embed mode for live support script or widget mode, or standard mode.
Multilanguage
Chats transfering
Departments
Files upload
Chat search
Automatic transfers between departments
Option to generate JS for different departments
Option to prefill form fields.
Option to add custom form fields. It can be either user variables or hidden fields. Usefull if you are integrating with third party system and want to pass user_id for example.
Cronjobs
Callbacks
Closed chat callback
Unanswered chat callback
Asynchronous status loading, not blocking site javascript.
XML, JSON export module
Option to send transcript to users e-mail
SMTP support
HTTPS support
No third parties cookies dependency
Previous users chats
Online users tracking, including geo detection
GEO detection using three different sources
Option to configure start chat fields
Sounds on pending chats and new messages
Google chrome notifications on pending messages.
Browser title blinking then there is pending message.
Option to limit pro active chat invitation messages based on pending chats.
Option to configure frequency for pro active chat invitation message. You can set after how many hours for the same user invitation message should be shown again.
Users blocking
Top performance with enabled cache
Windows, Linux and Mac native applications.
Advanced embed code generation with numerous options of includable code.
Template override system
Module override system
Support for custom extensions
Changeable footer and header content
Option to send messges to anonymous site visitors,
Canned messages
Informing then operator or user is typing.
Option to see what user is typing before he sends a message
Canned messages for desktop client
Voting module
FAQ module
Online users map
Pro active chat invitation
Remember me functionality
Total pageviews tracking
Total pageviews including previous visits tracking
Visits tracking, how many times user has been on your page.
Time spent on site
Auto responder
BB Code support. Links recognition. Smiles and few other hidden features :)
First user visit tracking
Option for customers mute sounds
Option for operators mute messages sounds and new pending chat's sound.
Option to monitor online operators.
Option to have different pro active messages for different domains. This can be archieved using different identifiers.
Dekstop client supports HTTPS
Protection against spammers using advanced captcha technique without requiring users to enter any captcha code.
Option for operator set online or offline mode.
Desktop client for
Windows
Linux
Mac
Flexible permission system:
Roles
Groups
Users
# Forum: http://forum.livehelperchat.com/
