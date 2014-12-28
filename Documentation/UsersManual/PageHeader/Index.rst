

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


Page header
-----------

The most of the configuration is on the page header of the directmail itself.


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

Page type
~~~~~~~~~
The main setting that makes a page a directmail is simply to set the page type to "Directmail".
In most respects the page will behave like a standard page.
The main changes are:

* A different icon in the page tree.
  The page will now be easily identifiable as a directmail.

* The "Directmail" tab.
  This tab contains the directmail specific settings.

Extra fields the "Directmail" tab
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Sender name
+++++++++++
This is the sender name as it will appear in the "From:"-header in the email.
If this is not set, 
it will default to either owning backend user name, site name or a defined name depending on configuration.

Sender email
++++++++++++
The is the sender email address as it will appear in the "From:"-header in the email.
If this is not set,
it will default to either owning backend user email address, a defined address or a deducted address depending on hostname and unix-user.

Bounce account
++++++++++++++
This is an optional different address to place in the "Return-Path:"-header.
If not set, it will take the same value ad sender email address.

Attempt to detect opened emails
+++++++++++++++++++++++++++++++
If you check this, TC Directmail will insert a link to a small transparent at the bottom of the HTML-part of the email.
The mail will not alter appearance,
but many MUA's will issue a warning about external references.
In exchange you will be able to get a statistic on how often the emails have been viewed.

Register clicked links
++++++++++++++++++++++
Check this if you wish to track what links your receivers click on.
The links will be transformed, so the directmail receiver will visit directmail server first,
before being redirected to the original link using a "HTTP/302 Found" response.
This could generate warnings about eavedropping or attempt of fishing.

Directmail send time
++++++++++++++++++++
Schedule the time to send the mail.
Note that clicking the "send now" button in the backend module essentially sets this value to now.

Directmail repeat
+++++++++++++++++
Upon completion of a directmail session,
reschedule a new send time in the future with this interval.

Real receivers
++++++++++++++
Define one or more direct mail receiver targets for the real receivers.

Test receivers
++++++++++++++
Define a direct mail target for testing.

Attach files to directmail
++++++++++++++++++++++++++
Attaching files to the directmail.
This is normal attachments and can be anything except PHP source code files.
Be aware that size and type policies both at the local and foreign MTA might empose contraints that we can't now and warn about here.
