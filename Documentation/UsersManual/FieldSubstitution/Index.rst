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


Field substitution
------------------

.. toctree::
   :maxdepth: 5
   :titlesonly:
   :glob:

Simple substitution
~~~~~~~~~~~~~~~~~~~
All the fields visible within the directmail receiver record can be substituted with the template marker (like ###name###).

What exact field are available depends on the selected receiver type(s).
Please take care if you are using different receiver types for test mails and real mails.


Advanced substitution
~~~~~~~~~~~~~~~~~~~~~
You can also use the fields as a boolean evaluation.
If you write the markers like this:

###:IF: name ###<p>Bla bla bla</p>###:ENDIF:###

The <p>Bla bla bla</p> will only be shown if the “name” field evaluates to true in PHP.

You can also make a else-branch:

###:IF: name ###<h1>Foo</h1>###:ELSE:###<h1>Bar</h1>###:ENDIF:###

This can be useful to present different content to different receivers.

Our experience shows that this has a tendency to get a little over engineered.


