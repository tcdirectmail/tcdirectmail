

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


Upgrade notes
=============

Before you upgrade, please make sure that:

- You are not in the middle of a directmail session.
  This will cause trouble since a running part of tcdirectmail might try to interface with newer versions of the database and tools.

- You have collected all the statistics you wish to see.
  Since TC Directmail database layout may be subject to change on each major release,
  your statistics might not show the correct numbers.

TC Directmail 3.x doesn't use a Cron job anymore and instead use the TYPO3 Scheduler. Be aware that the old CLI script found in /tcdirectmail/cli/mailer.phpsh doesn't work anymore so you need to remove the Cronjob and setup a new job in the Backend Scheduler module.

TC Directmail 2.0.x has a significanty different database layout from 1.x.
TC Directmail 3.0.0 has the same basic database layout as 2.0.x.
From version 4.0.0 the database layout is likely to undergo changes again.


