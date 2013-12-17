Installation Guide for Surveyor Elite
Requirements:

A PHP Platform or Apache Server - php_zip / php_pdo_mysqli extensions enabled.
Site must do URL rewrite - No file extensions or posts in URL of Survey or Test page.
A MySQL Database
 Jquery 1.7 or higher in Html <Head>.

I. FOLDER

When you download Surveyor Elite, and unzip, you will find inside the Surveyor-Elite folder, some text files (README, MySQL code) and another Surveyor-Elite folder.  This inner folder is the one you will install on your website.  Either copy or remove this folder and place it within the folder structure of your website at your desired location.	
Folder Structure is as follows:

REFER TO IMAGE FOLDER:  /manual/folders.png in download folder.

The above image represents useage.  Red should not me moved to your domain.  Green will not appear until you plibhs your first tracking reports.  Blue will be moved to your domain for use.

Platform Tips:

CodeIngniter 2 & bare Platform Structures: Install in a folder outside the System and Application folder. This is for security so Surveyor Elite paths will not be within the system. Because S.E. does not need system files, you can easily isolate the folder.
Drupal 7: Because of Drupal CMS, you must install in one of Durpal's designated areas. Install in "/misc" folder.
II. JQUERY
Edit /Surveyor-Elite/js/surveyor-elite_v1.0.0.js & /Surveyor-Elite/js/surveyor-elite-cms_v1.0.0.js to work on your platform.
This is very easy!  Surveyor Elite can be placed in any folder, however, it will only be able to locate itself if you set this to your local location:

REFER TO IMAGE FOLDER:  /manual/appPath.jpg in download folder.

At line 5 you will see:

/*-- end application execution --*/

Followed by line 6:

function _initPath(){ this._setPath = function(){ return("/*your local file path here*/");};};

Replace "/*your local file path here*/" with the file path between the base domain and the Surveyor-Elite folder.  This object assignment is used only once during initialization to allow the script to find itself within a platform file structure.  
  
If wwwFolder/Surveyor-Elite =>  function(){ return ("");   };
If wwwFolder/myApps/Surveyor-Elite =>  function(){ return ("/myApps"); };
If wwwFolder/myAssets/myApps/Surveyor-Elite =>  function(){ return ("/myAssets/myApps"); };

III. DATABASE
First you need a database.  It can be a current in-use, or a new empty one.  You will need to then enter the SQL code included in the MysqlTable.txt document in the downloaded folder.

Open /Surveyor-Elite/MysqlTables.txt.  This includes all tables needed for Surveyor Elite in Unicode & INNODB.  You can add to current database or create a new one if you want a separation. Tables include:

REFER TO IMAGE FOLDER:  /manual/table.jpg in download folder.

The code includes all information for the survey_defaults table to set up.  This is essential to operations. Either copy-and-paste into a SQL panel or import.
The code includes the Demo "The Daylily Quiz".  This is done to expedite setup and installation by allowing a user to test survey taking, timers, results, tracking, and tests without having to create a new survey for testing.  If you have installed Surveyor Elite in the past, you can remove this "INSERT" code for the `survey` and `survey_info` page.  Once you have tested after installation, you can "purge" the `survey` and `survey_info` tables.  The display page name for this is set to "demo".
If you don't use the Demo, you will get messages like "you haven't created any surveys yet" on the front end display page.
The defaults table has a setting if a site does not have a secure admin / login area.  When downloaded, the defaults table is set  to "ON" like this:

REFER TO IMAGE FOLDER:  /manual/admin-on.jpg in download folder.

These switches were created so Administrators could shut off CMS/admin access for either maintenance or if no secure admin exists. To manually shut off admin:

REFER TO IMAGE FOLDER:  /manual/admin-off.jpg in download folder.
						
This only turns off CMS access to database, and in no other way affects the application.  Reset to "ON" to restart access.
IV. PHP
Edit  /Surveyor-Elite/php/_config/class._connect.inc.php to work with your Database.
Assign the Object connecting the database.  Lines 5 to 8 of this file, in the "_SplRs1" function, has the following:

REFER TO IMAGE FOLDER:  /manual/setConnect.jpg in download folder.

Notice it is not only within an object, but you see a series of array checks.  This prevents your database information from being used unless stating one of these Array names, and this is sent from another object which pre-screened these names and sent them.  Also, after each "call" from Surveyor Elite, this object is cleared, so this password information can only be used ONCE each call from a client for the defined use, preventing open connection access and unauthorized database access through Surveyor Elite.	

Page Name: This is the name of the URL page name. "www.mysite.com/page-name" and "www.mysite.com/somefolder/anotherfolder/page-name" should be entered as 'page-name'. Surveyor Elite reads the URL and determines if the URL is valid and if a survey/test should be displayed.  If both are not correct, surveyor-elite does not initialize.
Site must do URL rewrites. Unacceptable page names are: page-name.html, page-name.php, or page-name.php?id=2. **(you can use extensions and URL posts in the admin area for image links and page anchors to "coupon" rewards.  We understand the survey may link to other sites or platforms, and made such possible).

When creating a CSM DISPLAY page to place the CMS panel, you must have the word "admin" in the page URL name.  These are all the variations, so you are not limited, and it can be anywhere in the page name (IE my_admin-page, Adminpage, cms-admin)

(pageName)_admin
(pageName)_Admin
(pageName)_ADMIN
 
admin_(pageName)
Admin_(pageName)
ADMIN_(pageName)
 
(pageName)-admin
(pageName)-Admin
(pageName)-ADMIN
 
admin-(pageName)
Admin-(pageName)
ADMIN-(pageName)
 
admin(pageName)  
Admin(pageName)  
ADMIN(pageName)
 
(pageName)admin
(pageName)Admin 
(pageName)ADMIN
				
admin
Admin
ADMIN


V. HTML
Inset empty display element into display page.
If this is your first time Installing and your are using the demo test, create a new page called "demo".  Surveyor Elite can be installed on any page at any location (Min width 20em). If you want to test the demo on an existing page, you will need to change the page name in the CMS or DB for the Daylily Quiz to the page on which you wish it to display.

For the Client Side Display: Within the page <BODY> of the front-end page, place the following EMPTY div element in the page as shown:

<div id="survey-content"></div>

Do NOT take and existing div containing information or elements, and add the ID to it.  Surveyor Elite will remove everything inside the element before beginning.

For the Admin CMS Display: Within the page <BODY> of the admin area on site, place the following div element in the page as shown:

<div id="survey_admin-content"></div>

***WARNING!!! The divs above must be a part of the initial page construction.  If you try to include the div after page render like using DOM, the survey will not work.  Part of App initialization is to make sure the "display div" is in page first, and if not, shuts off.
CodeIngniter 2 & bare Platform Structures:  Place inset div in the "view" or "page" you wish.

Drupal 7: Add  to "content" in cms.  Select "FULL HTML" for the text format and type <div id="survey-content"></div>.  It will appear in main content area of the page.
- OR -
Add the "survey_content" div to the template in which you wish it to appear (content, sidebar, footer, etc...).  If a survey has been created, it will appear here. We do not recommend placing in a space narrower than 140px.

VI. HEADER
Insert script link into <HEAD>
In Addition to the Jquery script link, you will need to place a link for surveyor-elite_v1.0.0.js OR surveyor-elite-cms_v1.0.0.js in the <HEAD>.  make sure the path here between the domain and the Surveyor-Elite folder matches the object information you put in the function at Section II. JQUERY:Folder Path.

***WARNING!!! DO NOT PUT BOTH SCRIPTS IN THE PAGE AT THE SAME TIME!  They are made to conflict to prevent the sharing of objects. Any attemps to run CMS and a Survey on the same page will result in both shutting down.

Drupal 7: Use the "drupal_add_js()" to add the scripts to the head. Include JQuery library if not already included.
THAT IS IT!   Please contact at the email on SurveyorElite.com of you run into issues.

