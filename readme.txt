=== Plugin Name ===
WP Business Directory FREE
Author: James Tibbles
Homepage: http://www.wpbusinessdirectorypro.com/free
Tags: business directory,search,business,map,listings,find,locate,businesses,wp business directory,free
Requires at least: 3.0.1
Tested up to: 4.9.5
Stable tag: 1.0.8.2
License: This free version can be used on any website. The full Pro version must be purchased directly at http://www.wpbusinessdirectorypro.com. Once purchased the Pro version can be used on multiple websites owned by that purchaser. Support and updates are provided for 2 years from purchase date.

A customisable, easy to use Wordpress Business Directory plug-in for Wordpress. Build and customise your own business directory in no time. More information can be found at www.wpbusinessdirectorypro.com.

== Description ==

Customise and theme your own Wordpress Business Directory with ease. Administer all business details from the WP admin area quickly and efficiently.
Theme your business directory to fit your website's design.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the folder `/wp-business-directory-free` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress. 
3. New pages will be generated automatically in the path `/wp-business-directory-free/`.
4. Navigate to Directory Pro->Settings to instantly activate your business directory.
5. For more information check out our Tutorials page at  http://www.wpbusinessdirectorypro.com/tutorial/ or ask a question on our support page at  http://www.wpbusinessdirectorypro.com/support.

== Frequently Asked Questions ==

= Where is my Business Directory search page? =

Once you've set up the details on the settings page you should see your business directory at www.YOURWEBSITENAME.com/business-directory/.
Users can add a new business at www.YOURWEBSITENAME.com/business-directory/new-business/.

The URL's can be changed if required, and all other business directory pages will reside within a sub-directory of the main Business Directory page. 
Eg. If your business directory starts at www.YOURWEBSITENAME.com/SOMEPAGE/ , the Add Business page would be located at www.YOURWEBSITENAME.com/SOMEPAGE/new-business/

= Where is my admin area? =

All admin sections for the plug-in can be found under the "WPBD Free" link in your Wordpress admin area. 

= How can I customise the look of the business directory? =

The plug-in was built with customisation in mind. You will require HTML and CSS skills to change the way it looks.
Locate the "template" folder within the plug-in directory. Copy it ad paste it in to your own theme's root directory.
Next, rename this copied folder to "wpbdf". You can now edit any or all of the files within this folder. 
The plug-in will look for your theme's "wpbdf" folder first. If it can't find a customised version it will revert back to the default version.
Be careful when editing the files. There are various references to PHP variables and functions. You should avoid editing the PHP code unless you are PHP savvy.

Avoid amending the files directly in the `/wp-business-directory-free/templates/` folder, as these will be overwritten when new updates are released. Also please keep in mind future updates to the plug-in may include updates to the original template files, so you may need to modify your custom files as and when they predate newer core versions. 
To check that your custom files are in-date, navigate to the "wpbdf->Custom Theme Files" option in your Wordpress admin area. Out-of-date theme versions will be indicated here.

= The website mentioned something about downloading more themes? =

We are currently developing this ability now. Over time we hope to provide you with a number of different themes that you can place in your Wordpress theme's "wpbdf" folder. 

= I want to customise the look of my business directory but it's quite specific and I don't know how to do it myself =

Please get in touch with us via the forum and we'll see if we can help locate a designer for you. 

= I'm not sure what to do...with any of it :S =

Visit our tutorial page at http://www.wpbusinessdirectorypro.com/tutorial/ for some pointers. If you are still unsure please get in touch via our email form or the support forum.

= Can I use this plug-in on another website? =

YES! Use it where-ever and whenever you want, provided you don't re-sell the plug-in or repackage it in any way (reselling the plug-in is prohibited and protected by governing laws).

= I've found a bug - what do I do =

Every effort has been made to fix any bugs but, as is always the case, sometimes bugs crop up. Don't panic. Simply report the bug to us and we'll investigate as soon as possible and if required we'll post an update to the plug-in.

= I've got some requests for future updates to the plug-in =

Great! We're always looking for ways to improve. Please log your ideas on our support forum. We'll consider every idea for our future updates.

= What does the PRO version offer that the free version doesn't? =

The PRO version offers an even more comprehensive Business Directory with features including:
- A Tiered Subscription System - flexible, customisable and can be tied to an in-built subscription payment mechanism.
- Google friendly Ratings - Easy to use, SEO friendly ratings system.
- User Reviews - Reviews can be placed and moderated with ease.
- Bulk Importing - Import hundreds of businesses at once with our CSV import tool.
- User Ownership / Claiming - Your users can become "owners" of a business. They can edit the business (subject to approval), pay for subscriptions or request additional features such as an upgrade or a feature listing. This is all controlled from their own User Dashboard. 
- More Business Options - Additional business details such as opening hours and business awards.

Check out all the benefits at www.wpbusinessdirectorypro.com

= Do you have any other plug-ins? Do you build custom plug-ins? =

Yes and yes. Please visit the author's main website at www.jamestibbles.co.uk

Why not check out my competition plug-in: http://www.jamestibbles.co.uk/no-frills-prize-draw-pro

== Changelog ==

= 1.0.8.2 =
- Further amendment to javascript long/lat check to prevent clearing of values when address not found

= 1.0.8.1 =
-Add HTML to description

= 1.0.8 =
- Amendment to javascript long/lat check to prevent clearing of values when address not found
- Ensure versin number correctly shown in admin area

= 1.0.7 =
- Fix PHP warning if missing vales in wpbdf-view-all-businesses.php
- Fix PHP warning on double-slash when referring to custom theme folder

= 1.0.6 =
-  removed stray character in edit/create admin js that was preventing some features from working correctly
-  amended php bug in image slideshow
-  margin-bottom css added to business details css page (in templates)

= 1.0.5 =
-  minor fix to languages init call

= 1.0.4 =
- readme text amends
- Logo added

= 1.0.3 =
- Further sanitisation amends

= 1.0.2 =
- New sanitisation function for all inputted values using custom function "wpbdf_sanitiser"
- Renaming of functions for uniqueness
- session_start() called only in required functions

= 1.0.1 =
- Sanitisation of all user inputted values
- Additional sanitisation of db-outputted data
- Javascript error regarding missing google map, prevented new image uploads. Fixed.
- Style error causing overlap after image slideshow. Fixed.

 == Upgrade Notice ==

= 1.0.8.1 =
- None yet
