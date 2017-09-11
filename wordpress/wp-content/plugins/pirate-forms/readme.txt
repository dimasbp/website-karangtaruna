=== Contact Form & SMTP Plugin for WordPress by PirateForms ===
Contributors: themeisle, codeinwp, rodicaelena, hardeepasrani, pirateforms
Tags:  contact form, contact form plugin, forms, smtp, custom form, subscribe form, feedback form, wordpress contact form
Requires at least: 3.0
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

A simple and effective WordPress contact form & SMTP plugin. Compatible with best themes out there, is both a secure and responsive contact form plugin.

== Description ==

Stay in touch with your visitors very easily. <a href="https://themeisle.com/plugins/pirate-forms/" rel="nofollow">Pirate Contact Forms</a> offers you a great and friendly contact form for your website.
This is an easy-to-use WordPress contact form with captcha plugin. To create a contact form you just need to use the [pirate_forms] shortcode or use the WordPress contact form widget.


**Why use our responsive WordPress Contact Form:**

- It's easy to use

This Contact Form 7 or any form builder alternative is very easy to set up. You can quickly create an engaging contact form by using a shortcode and copying it where you want it to appear.

- It's fully customizable

This WordPress Contact Form plugin allows you to customize everything you want. You can change the field labels and decide what message to tell your visitors when an error shows up. You can also decide which fields are required and which are not.

- Provides reCaptcha

Avoid spam messages and make sure the e-mails you receive are entirely addressed to you.

- Comes with SMTP

With the SMTP option, you can be sure you won’t miss any e-mail from your visitors. The messages will be safely delivered from the source to your personal e-mail address.
If you were using Mandrill's SMTP for transactional emails and contact forms, you should take a look at these <a href="http://www.codeinwp.com/blog/mandrill-alternatives/" rel="nofollow" target="_blank">Mandrill Alternatives</a>.

- Stores contacts in special databases

You can keep all the contacts in an archive by saving their e-mail addresses. Pirate Contact Form allows you to do that by providing contact databases.

A simple to use contact form plugin for creating a clean contact form using the [pirate_forms] shortcode or the 'Pirate Forms' form widget.

- What PirateForms isn't for now


This is not a form maker or drag & drop builder plugin nor "the best contact form plugin", you cannot add new fields or create multiple forms (subscription forms, payment, order, feedback or quote), there are some great alternatives out there for those like : Caldera Forms or Ninja Forms.



We've also built some fantastic <a href="http://themeisle.com/wordpress-themes/free/" rel="nofollow" target="_blank">free themes</a> that work well with Pirate Contact Form, check them out.

**Features:**

- Choosing the fields(required or not)
- Choosing the labels
- Choosing error messages
- reCAPTCHA
- Store the contacts in the database

If are you looking for other alternatives check-out our article on <a href="http://www.codeinwp.com/blog/best-contact-form-plugins-wordpress/" rel="nofollow" target="_blank">best contact form plugins</a>.



This plugin started as a fork of https://wordpress.org/plugins/proper-contact-form/.

== Frequently Asked Questions ==

= How I can get support for this contact form plugin ? =

You can learn more about PirateForms and ask for help by <a href="https://themeisle.com/contact/"  >visiting ThemeIsle website</a>.

= What can i do with this plugin =

You can follow the full documentation [here](http://docs.themeisle.com/article/436-pirate-forms-documentation)

= How to Change Pirate Forms Submit Button Color =

[http://docs.themeisle.com/article/423-how-to-change-pirate-forms-submit-button-color](http://docs.themeisle.com/article/423-how-to-change-pirate-forms-submit-button-color)

= How to Center the Send Message button for Pirate Forms =
[http://docs.themeisle.com/article/427-how-to-center-the-send-message-button-for-pirate-forms](http://docs.themeisle.com/article/427-how-to-center-the-send-message-button-for-pirate-forms)

= How to change font in Pirate Forms =
[http://docs.themeisle.com/article/431-how-to-change-font-in-pirate-forms](http://docs.themeisle.com/article/431-how-to-change-font-in-pirate-forms)


= How you can overwrite the default form template in Pirate Forms =
[http://docs.themeisle.com/article/664-how-you-can-overwrite-the-default-form-template-in-pirate-forms](http://docs.themeisle.com/article/664-how-you-can-overwrite-the-default-form-template-in-pirate-forms)


= What actions and filters are available in Pirate Forms =
[http://docs.themeisle.com/article/663-what-actions-and-filters-are-available-in-pirate-forms](http://docs.themeisle.com/article/663-what-actions-and-filters-are-available-in-pirate-forms)


== Installation ==

Activating the Pirate Contact Form plugin is just like any other plugin. If you've uploaded the plugin package to your server already, skip to step 5 below:

1. In your WordPress admin, go to **Plugins &gt; Add New**
2. In the Search field type "pirate forms"
3. Under "Pirate Forms," click the **Install Now** link
4. Once the process is complete, click the **Activate Plugin** link
5. Now, you're able to add contact forms but, first, we could configure a few settings. These can be found at **Settings &gt; Pirate Forms**
6. Make the changes desired, then click the **Save changes** button at the bottom
7. To add this form to any page or post, just copy/paste or type "[pirate_forms]" into the page or post content and save. The form should appear on that page


== Screenshots ==

1. Screenshot 1. How to use contact form in posts/pages
2. Screenshot 2. How to customize contact form labels
3. Screenshot 3. How to use reCaptcha
4. Screenshot 4. Enabling SMTP

== Changelog ==
= 2.0.1 - 2017-08-01  = 

* Fixed backwards compatibility with Zerif themes


= 2.0.0 - 2017-08-01  = 

* Major code refactor ( Please TEST BEFORE updating).
* Added multiple filters and hooks to be easily extended by developers. 
* Fixed some issues with attachment fields.
* Added support for TLS.
* Added support to change browser required messages.



= 1.2.0 =

* Fixed security error when upload field was active.

= 1.1.3 =

* Added integration with custom emails plugin
* Fixed text domains errors

= 1.1.0 =
* Escape form fields ( Thanks to Gabriel Avramescu gabriel.avramescu@ituniversity.ro )

= 1.0.18 =
* Fixed php strict standards error
* Update tags
* Tested up to WordPress 4.6

= 1.0.17 =
* Fixed IP issue when using web server behind a reverse proxy
* Fixed W3C compatibility issues
* Remove pcf=1#contact from url when theme is different then Zerif
* Removed blacklist option and made it default set to true
* Display site key and secret key fields only if recaptcha option is selected
* New attachment option
* New thank you URL option
* New option to make the nonce optional

= 1.0.16 =
* textarea field not saving

= 1.0.15 =
* Update screenshots
* Added a clearfix after the Pirate Forms widget to avoid messed layout
* Update compatible WordPress version number

= 1.0.14 =
* Fix issues with checkboxes not saving data
* Redo the layout of the plugin's admin area

= 1.0.13 =
* Fix issues with multiple forms on same page
* Update readme.txt

= 1.0.12 =
* Update contributors names
* Option to change recaptcha language

= 1.0.11 =
* Fixed #55 Recaptcha too down

= 1.0.9 =
* Fixed layout issues #52

= 1.0.8 =
* Update readme.txt
* Update translations files
* #42, translation issues fixed
