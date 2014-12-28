

.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)

Installation
------------
When you install tcdirectmail, please take a look at the options below.
There are two main sections.

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

Identity
~~~~~~~~~

These setting define the directmails identifications.
It is important that they are set up to fit your site.

sender_name
+++++++++++
If the sender name is provided at the page,
this will again always take precedence.
If the page sender name is empty,
it will be used,
unless the value is "user",
in which case the owning backend users name will be used.
If all values are empty then the sites name will be used.

sender_email
++++++++++++
This is similar to the sender_name.
This is a setting to provide a fall back policy for the sender email for the directmails.
If there is a sender address provided on the page,
this will always take precedence.
If however that value is empty,
then this parameter comes into play.
If the value here is an valid email address,
then that value is used.
If the value here is set to "user",
then the owning backend users email address is used.
If all values are empty then "no-reply@<HTTP_HOST> it used.

System
~~~~~~
These settings are for making TC Directmail play well with your syste,

attach_images
+++++++++++++
Make TC Directmail resolve images and attach them as inline images.
This will increase the mail size,
but make the mails less prone to warnings and blocking at the receiver.

path_to_lynx
++++++++++++
Supply the path the the Lynx cli-browser.
This browser can be used to process HTML into plaintext without any efford.

append_url
++++++++++
Extra URL-segment to append to the URL.
This is useful if your newletter has a special typeNum.

fetch_path
++++++++++
Hostname and path to the TYPO3 installation.
This is normally not required,
but can be used in some cases if DNS does not resolve on the server.

mails_per_round
+++++++++++++++
This is the amount of mails the mailer job will send in one invocation.

show_invoke_mailer
++++++++++++++++++
This enables the mailer button in the backend module.
Uncheck if you only wish mailing done with the scheduler.
