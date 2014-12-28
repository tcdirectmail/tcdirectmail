

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


Prerequisites
=============


.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

A TYPO3 site
------------
Obviously you need a TYPO3 site, preferably hosted on a unix-webserver like Linux or FreeBSD.
Windows is largely untested, but should work.

Working DNS and HTTP
--------------------
In order for anything to work, your webserver needs to have working
DNS, so it can resolve domain-names and so on. It also needs the
ability to fetch files over HTTP. In short, if the extension manager
works, you should be home safe. If this is not the case, please
contact your system administrator.

Data sources
------------
You must have a source type for your receivers. The default supported
types are:

- be\_users

- fe\_users from fe\_groups

- fe\_users from pages

- tt\_address from pages

- A HTML-file

- A CSV-file
  
  ...as these are directly supported.

You also have the possibility of using freestyle SQL, to download extra receiver types from TER or to make your own types. 
Please note that not all receiver types provide the same functionality.




