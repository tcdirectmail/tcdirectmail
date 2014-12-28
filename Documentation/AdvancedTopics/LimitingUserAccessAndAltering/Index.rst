

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


Limiting user access and altering
---------------------------------

The interface and permissions of tcdirectmail and TYPO3 can be altered
to limit your users access to directmail functions and liberty to
change attributes. First you might want to limit access to certain
parts of the backend module. This can be done with user-TS-config.
This example removes the users access to statistics and previews:

::

   tcdirectmail.modfuncDisallow {
     preview = 1
     statistics = 1
   }


You can also alter the way the TCA-form looks in the backend. This
page-TS-config example removes &type=99-plaintext method and enables
clicklinks by default:

::

   TCEFORM.pages {
     tx_tcdirectmail_plainconvert.removeItems = tx_tcdirectmail_plain_template
     tx_tcdirectmail_register_clicks = 1
   }

It is also possible to use defaults.This user-TS-config example will
use the Chuggnut converter by default:

::

   TCAdefaults.pages.tx_tcdirectmail_plainconvert = tx_tcdirectmail_plain_html2text




