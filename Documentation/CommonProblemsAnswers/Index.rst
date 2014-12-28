

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


Common problems & answers
=========================

Many of the same questions keeps appearing on the mailing lists. A
couple of the most common.

*Q: I can send test mails, but the real mails are going nowhere.*

A1: TC Directmail is using TYPO3's Swiftmailer.
Confirm that it is configured correctly using the install tool.

A2: Confirm that you have activated the Scheduler job.
Without the scheduler job the mails will just queue up.
Be careful if you have been playing around with your setup.
If you suddenly get it working,
take care that there are not loads of mails in queue.
This is a common mistake and has caused a lot of people a lot of grief in the past.

*Q: I am using Windows. Can I use this extension?*

A: Yes, while TC Directmail was developed on and for unix systems,
it also works with Windows to a certain degree.
Issues that we are aware of:

- Fetchmail doesn't run on Windows.
  Therefore you are unable to collect bounced emails the normal way.

- Performance might be a problem using Windows hosts.
  Consider using a fast MTA like Postfix or Exim for fast delivery.

*Q: In my log/in the preview/in the mail validator this message keeps
appearing.*  **Warning** :
file\_get\_contents(http://mydomain/index.php?id=666&no\_cache=1)
[function.file-get-contents]: failed to open stream: HTTP request
failed! HTTP/1.1 404 Not Found ..... *Also the pictures are missing in
the mail.*

A1: You are using RealURL and the domain and baseURL are different.
They must be equal if tcdirectmail are to encode the pictures
correctly.

A2: You don't have working DNS on your server. Edit your resolv.conf
and try again.
