

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


Backend page module
-------------------

The Directmail backend module provides the functionality not properly placed elsewhere. 
It has five functions:

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

Status
~~~~~~
This part tells you about the current status of the page you're on.
If there are configured recipients and if any send is scheduled.
There is also the possibility of sending a test mail if any test receivers are attached to the mail.

Statistics
~~~~~~~~~~
The standard statistics part is divided into two sections.
One general screen with an overview of the different mailing sessions.
Stating date and time of mailing sessions.

The second part is a details screen,
where you can extract data about bounced mails, confirmed mails, and mails with specific links activated.

Maintenance
~~~~~~~~~~~
Use the function to clean up old and invalid statistics from past directmail sessions.
If you've copied a directmail page or aborted a mailing session,
you could have invalid log data.

Important:Do **not** delete the statistics from a mail that is currently sending.
This will mess up the send queue.
Further more; if you are collecting link statistics,
do not delete it before people are expected to have read their mails.
If you do se, the click-links will be rendered unusable,
ending with a "500 Internal Server Error" result instead of the correct link.

Mail validity
~~~~~~~~~~~~~
This function gives you advice on the technical quality of your mail.
It tries to detect any possible problems your mail might have in different MUA's.
The very common Outlook Express and Mozilla Thunderbird are pretty robust,
but webmail agents such as Hotmail,
Gmail and SquirrelMail and more rare agents such as Kmail and Lotus Notes are much more picky.
To maximize the experience for your receivers please take care here.

**Note**: The experiences that went into section is likely outdated.
If you have any experience into this,
consider supporting TC Directmail by improving this code.
You can find us on Github.


Preview
~~~~~~~
Here you can peek at how the mails might look like in the receivers inbox.
Both html and plaintext.
You can also get warnings if your mail contains fields that are not substituted.

