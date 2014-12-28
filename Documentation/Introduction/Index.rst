

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


Introduction
============


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

What does it do?
----------------
This extension provides the ability to send out newsletters from your
TYPO3 installation.

It has a very flexible method to configure recipients, and an
(hopefully) intuitive way of creating newsletters from within TYPO3.

It provides improved performance over TYPO3's old direct\_mail
extension.


Why make this?
--------------
This extension has been born out of several shortcomings in the
original direct\_mail extension, mainly:

- Non-intuitive setup of directmail.
  With the older direct\_mail versions it was nearly impossible to setup and test without consulting the manual several times.
  Especially the “fetch and compile”-stuff is hard to understand.

- Limited configuration.
  The concept of categories and the possible source tables, are often too limiting.
  Often I would like to use a lot of different fields, sometimes from different tables.
  It should also be possible to make these configurations in an user friendly fashion.

- Overflow/multisend problem.
  Way too often we have had problems with multiple dmailer processes starting on top of each other,
  sending the same mails multiple times,
  because the first one failed to finish in 60 seconds.

I addition to this I would like to make the mailer faster, and to make
possibility of periodic mailing. So we can schedule the directmail to
be send later on a day, a week or other common amounts of time.

Since then direct\_mail have improved in several ways.

Please do not spam
------------------
Even though this software technically enables you to do so, 
please do not use it to send out spam.



