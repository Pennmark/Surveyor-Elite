------------------------------------------------------------------------------------------------
WELCOME TO SURVEYOR ELITE!
Author: Mark Bazzone
Copyright: 2013
www.surveyorelite.com , www.surveyorelite.net , www.surveyorelite.org.
------------------------------------------------------------------------------------------------
This Document includes: REQUIREMENT, INSTALLATION, OPERATION TIPS
------------------------------------------------------------------------------------------------
I. REQUIREMENTS.

1. A PHP PLATFORM - WITH php_zip / php_pdo_mysqli extensions enabled

2. SITE MUST DO URL REWRITES - NO FILE EXTENSIONS OR POSTS IN URL OF SURVEY/TEST DISPLAY PAGE

3. A MYSQL DATABASE

4. JQUERY 1.7 OR HIGHER LINK MUST BE IN PAGE <HEAD> - Visit Jquery.com for latest link.  You can also download a version to put on your site.

II. INSTALLATION.

***Surveyor Elite Requires Manual Installation.  This application is for Jr.- Sr. level Programmers, Businesses,or anyone who works website internals, understands the responsibility of personal information and tracking, and would be able to use the final XML output.   This tool is for the Professional and the Professional minded individual or organization.

--------------------------------------------------------------------------------------------

A.  EDIT /Surveyor-Elite/js/surveyor-elite_v1.0.0.js AND /Surveyor-Elite/js/surveyor-elite-cms_v1.0.0.js TO WORK ON YOUR PLATFORM.
		
1. This is very easy!  Surveyor Elite can be placed in any folder, however, it will only be able to locate itself if you set this OBJECT to your local location.
			
2. At line 5 you will see:

	/*-- end application execution --*/
					
3. Followed by line 6:

	function _initPath(){this._setPath = function(){ return("/*your local file path here*/");};};

4. Replace "/*your local file path here*/" with the file path between the base domain and the Surveyor-Elite folder.  This object assignment is used only once during initialization to allow the script to find itself within a platform file structure.    

---If wwwFolder/Surveyor-Elite. 
					
	function(){ return ("");   };
					
---If wwwFolder/myApps/Surveyor-Elite

	function(){ return ("/myApps"); };
					
---If wwwFolder/myAssets/myApps/Surveyor-Elite

	function(){ return ("/myAssets/myApps"); }; 

-------------------------------------------------------------------------------------------

B.  CREATE OR EDIT A DATABASE  TO PLACE THE /Surveyor-Elite/MysqlTables.txt.
		
1. Open /Surveyor-Elite/MysqlTables.txt.  This includes all tables needed for Surveyor Elite in Unicode & INNODB.  You can add to current database or create a new one if you want a separation. Tables include:
				
	survey_defaults, survey, survey_info, survey_results, _survey_tcr.
					
2. The code includes all information for the survey_defaults table to set up.  THIS IS ESSENTIAL TO OPERATIONS. Either copy-and-paste into a SQL panel or import.
			
3. The code includes the DEMO "The Daylily Quiz".  This is done to expedite setup and installation by allowing a user to test survey taking, timers, results, tracking, and tests without having to create a new survey for testing.  If you have installed Surveyor Elite in the past, you can remove this "INSERT" code for the `survey` and `survey_info` page.  Once you have tested after installation, you can "purge" the `survey` and `survey_info` tables.  The display page name for this is set to "demo".  More details will be in Section D of INSTALLATION.
			
4. If you don't use the DEMO, you will get messages like "you haven't created any surveys yet" on the front end display page.

--------------------------------------------------------------------------------------------

C.  EDIT  /Surveyor-Elite/php/_config/class._connect.inc.php TO WORK WITH YOUR DATABASE.
			
1. Assign the Object connecting the database.  Lines 5 to 8 of this file, in the "_SplRs1" function, has the following:
			
	$MyDb->host = '/*your host name*/'; 
	$MyDb->database = '/*your database name*/'; 
	$MyDb->username = '/*your user name*/'; 
	$MyDb->password = '/*your password name*/'; 
2. replace the /*you...name*/ with the appropriate information.
			
3. Notice it is not only within an object, but you see a series of array checks.  This prevents your database information from being used unless stating one of these Array names, and this is sent from another object which pre-screened these names and sent them.  Also, after each "call" from Surveyor Elite, this object is cleared, so this password information can only be used ONCE each call from a client for the defined use, preventing open connection access and unauthorized database access through Surveyor Elite.		

--------------------------------------------------------------------------------------------

D.  INSERT DISPLAY ELEMENT INTO DISPLAY PAGE
		
1. If this is your first time Installing and your are using the demo test, create a new page called "demo".  Surveyor Elite can be installed on any page at any location (Min width 20em). If you want to test the demo on an existing page, you will need to change the page name in the CMS or DB for the Daylily Quiz to the page on which you wish it to display.
			
2. Page Name: This is the name of the URL page name. "www.mysite.com/page-name" and "www.mysite.com/somefolder/anotherfolder/page-name" should be entered as 'page-name'. Surveyor Elite reads the URL and determines if the URL is valid and if a survey/test should be displayed.  If both are not correct, surveyor-elite does not initialize.

3. Site must do URL rewrites. Unacceptable page names are: page-name.html, page-name.php, or page-name.php?id=2. **(you can use extensions and URL posts in the admin area for image links and page anchors to "coupon" rewards.  We understand the survey may link to other sites or platforms, and made such possible).
			
4. For the Client Side Display: Within the page <BODY> of the front-end page, place the following div element in the page as shown:
				
	<div id="survey-content"></div>  OR  <div id='survey-content'></div>

5. When creating an ADMIN page to place the CMS panel, you must have the word "admin" in the page URL name.  These are all the variations, so you are not limited, and it can be anywhere in the page name (IE my_admin-page, Adminpage, cms-admin)

	_admin, _Admin, _ADMIN, admin_, Admin_, ADMIN_, -admin, -Admin, -ADMIN, admin-, Admin-, ADMIN-, admin, Admin, ADMIN	
					
6. For the Admin CMS Display: Within the page <BODY> of the admin area on site, place the following div element in the page as shown:
			
	<div id="survey_admin-content"></div>  OR  <div id='survey_admin-content'></div>
					
WARNING!!!***The divs above must be a part of the initial page construction.  If you try to include the div after page render like using DOM, the survey will not work.  Part of App initialization is to make sure the "display div" is in page first, and if not, shuts off.  
					
IMPORTANT!!**The defaults table has a setting if a site does not have a secure admin / login area.  When downloaded, the defaults table is set  to "ON" like this:
			
	ID# 32 	active 		surveyType 	Admin-On 
	ID# 33 	inactive	surveyType 	Admin-Off 
				 
These switches were created so Administrators could shut off CMS/admin access for either maintenance or if no secure admin exists. To manually shut off admin:
			
	ID# 32 	inactive	surveyType 	Admin-On 
	ID# 33 	active 		surveyType 	Admin-Off 
						
This only turns off CMS access to database, and in no other way affects the application.  Reset to "ON" to restart access.

--------------------------------------------------------------------------------------------

E.  INSERT SCRIPT LINK INTO PAGE HEADER
			
1. In Addition to the Jquery script link, you will need to place a link for surveyor-elite_v1.0.0.js AND surveyor-elite-cms_v1.0.0.js in the <HEAD>.  make sure the path here between the domain and the Surveyor-Elite folder matches the object information you put in INSTALLATION: SECTION A.

THAT IS IT!   IF PROPERLY INSTALLED, YOU SHOULD BE ABLE TO GO TO A PAGE CALLED DEMO AND TAKE THE DAYLILY QUIZ.  YOU SHOULD BE ABLE TO VIEW THE CMS THROUGH AND ADMIN PAGE AND CREATE NEW SURVEYS OR TESTS.


III. OPERATION.

A.  EASY:

Operation should be self explanatory.  Make sure to read instructions included in the CMS.  
		
B.  LINKS:

When entering URLs for links or images in the CMS, it is recommended to use full http:https addresses to ensure link will work.  
		
C.  TEXT COUNTS:

Most text inputs have text counters that work as you type.  
		
D.  ACTIVATION:

Survey info pages set to "active" but have no questions will show up but will not activate.  Information and Questions should be set to Inactive until ready to publish.  Finished questions set to "active" but the information page set to "inactive" should be the proper settings pre-launch, so activating live only requires setting "active" the survey information. All information, whether "active" or "inactive" will appear in the CMS
		
E.  SURVEY INFORMATION:

Each Survey Information page has 4 paragraph slots: Overview, Purpose, Time Length, and Closing.  If you want 3 paragraph on the info page, but don't want to follow the "title layout", merely set Info Titles to "false" on the survey info CMS page.  Then you can place up to 3 paragraphs a the start and 1 at the end stating anything you wish in any order.
		
F.	INACTIVE DATA:

Because tracking and results are collected, the programmer did not want to create a situation under any case where a question or info could be deleted.  This is because those creating/inputting data may not be the same people collecting tracking and results.  Though the tests and surveys can be judged independently, the only master document to compare to for errors or problems is the survey or test on the database. The programmer did not want a test deleted only to be needed months later to verify a test was scoring accurately.
		
The same is with questions.  This allows a survey to evolve over time, yet old questions to sit inactive in case old results and new results can to be compared to the same test.
		
To delete survey_info, survey, survey_results, and _survey_tcr data permanently, users will need to either delete directly from the database, or create scripts to clean these tables.  This is strongly recommended, because a company working successfully with Surveyor Elite will want and need to make cron jobs and archives to prevent database tables from becoming too big, and XML folders filled with every user's info and results.
		
G.  PUBLISHING AND RE-PUBLISHING DATA	

When data is published in the CMS from the database to XML files it is marked in the database table.  the row `exported` in the `survey_results` and `_survey_tcr` Tables is and enum with 3 choices: new, ready, and exported.

	new = set when data first collected.
	exported = set when data published.
	ready = for you!
		
That's right, "ready" is for you.  The system will publish "ready" files as if new.  Yet you can reset files you need to re-publish and keep then easily identifiable.  This can be done in the DB/sql or by php script created by the user.
				
Because the range of use of the tracking and results, it was best accumulated manually.  User tracking during tests can be open for hours, thus publishing results while being taken.  Generating on completion does not compensate for surveys where users were disconnected, or landed on the page but did not take a survey, but whose information was collected.  A business could have collected 10 or 100,000 results in minutes, and large publishing jobs executed at the wrong time could jam up survey takers. 1000 was chosen, because it was determined that the User Experience was fast enough the user was never waiting and could publish 100,000 results in minutes with only 100 clicks (server speed will affect publish speed).
		
The solution was units of 1000 that could be executed by the administrator when determined. Advanced programmers can increase this number in  the "adminPublisherCreate" function  && "adminDownloadCreate" function &&  "var countSplit = 1000" all in the JS files.   At these locations, change "1000"  to whatever number you system can handle.  The PHP scripts are set to force the connection to stay open, so a major site can set the number to "5,000" per button or higher if they wish, providing they don't close the page until the server is done.
		
Both Zip and download are single click for all results and tracking.  Download searches to verify a zip folder before allowing download. All downloads are zipped.