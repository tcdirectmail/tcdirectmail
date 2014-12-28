.. include:: Images.txt

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


Making new directmail receiver-types
------------------------------------

The directmail receiver-types are programmed with an object-orientated approach that enables you to make any data source integrate nicely with tcdirectmail.
You can use any kind of data,
provided that you obey these naming conventions for field names:

- “email”.
  Each record must contain a field named “email”,
  or they receive no mails.

- “uid”.
  You can provide a “uid” field for each user.
  This is needed if you wish to receive and process bounce mails.

- “authCode”.
  This code should be calculated on the basis of “uid”.
  This is also needed if you wish to receiver and process bounce mails.

- “L”.
  You can deliver newsletters in multiple languages if you provide the “L” field.
  This is the same “L” as the one you use in multilanguage pages on the frontend.

- “plain\_only”.
  If your users wants to choose between html and plain text content,
  you can provide the “plain\_only”-field.
  A value of 0 will get the user a html-mail.
  A value of anything else will get the user a plain-text mail.

The class must extend "tx_tcdirectmail_target",
and must be registered in **$TCA['tx_tcdirectmail_targets']['columns']['targettype']['config']['items']**.
Please look at the source code on which methods to implement.

