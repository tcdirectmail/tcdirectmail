

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


Setting up Scheduler job
========================

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

Browser mode
------------
You can choose to run the mailer in the browser only.
This works fine for smaller installations with maximum a couple of hundreds receivers.
In this configuration you can click the “Invoke mailer” button on the status page, in the backend module.

No further configuration is required if this is your only demand.

Scheduler job
-------------
If you have a large volume of mails,
your should activate the Scheduler job.
The Scheduler job should be configured as a recurring job,
with frequency each minute.
If you wish to lower the load (and thereby lengthening the queue time),
you can raise the frequency,
or consider lowering the "mails_per_round" parameter.
TC Directmail will not process mails in parallel,
so you can not get faster send times trying parallel execution.

Handling bounce mails
---------------------
In order to handle bounced mails you can pipe the mail through the bounce handler.

Using direct SMTP delivery
~~~~~~~~~~~~~~~~~~~~~~~~~~
The goal is to pipe the mailbody into the bounce handler on STDIN.
The simplest way to achieve this is the following:

* Make sure you are using a specific email address for sending out directmail.
  The mails should contain this address in the "Return-Path" header.
  The format should be like "bounce@server.example.com".

* Make sure that you have set a proper MX-record for your server.
  In your zone-file this will look something like this:

  ``server   IN MX 10   server.example.com.``

  This way all mail for the server.example.com domain will be delivered directly to your server on SMTP.

* On the server now create an aliases entry (/etc/aliases) to pipe all mails for "bounce" directly into.
  It will look something like this:

  ``bounce:          "| /var/www/t3site.example.com/htdocs/typo3/cli_dispatch.phpsh bounce_mail"``

Using mailbox retrieval
~~~~~~~~~~~~~~~~~~~~~~~
There might be several reasons why this setup might not work for you.
If you do not want to have the Return-Path address on a subdomain,
maybe you are can not have direct SMTP-connections to your server for security reasons,
or maybe there is some other obstacle.
In this case you might want to look into using fetchmail(1).
The fetchmail(1) utility allows retrieval from a POP3 or IMAP ressource,
and can be used to pipe mailbody into "typo3/cli_dispatch.phpsh bounce_mail".
Parameters to consider:

* -m Delivery command.
  This must point to "/var/www/t3site.example.com/htdocs/typo3/cli_dispatch.phpsh bounce_mail".

* -b Batch limit.
  Must be 1.
  TC Directmails bounce handler handles only one mail at a time.

* -k or -K.
  Optional parameters give you the option to keep or delete mail on the server after retrieval.
  This may or may not be useful depending on your usage of the mailbox.

You should setup this fetchmail-run using a unix crontab.
