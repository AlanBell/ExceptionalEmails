<h3>How reliable is this service?</h3>
Pretty good, it is running on reliable infrastructure in the Hetzner datacentre in Germany. The important thing is not that our
systems are 100% reliable, but that they are 100% <b>independent</b> of your systems. If we are down for a few minutes we will pick
up emails queued up from your servers when we come back and everything will be fine because the chances that your systems needed
a notification during that period are quite low. The combined system has an overall reliability of our failure probability
multiplied by your failure probability, so if we are 99.9% up and you are 99.9% up (10 hours a year of downtime - we are
better than that) then a dual failure (where you have a problem and we fail to tell you about it as soon as we could because we have a problem)
is going to happen 0.1% of 0.1% of the time, or 0.0001% so that is a 99.9999% combined reliability. This hinges on independence,
if you are in the same datacentre as us then a flood/fire/meteroite could take out both of us at once. If you are in one of the
public clouds or your own datacentre or anywhere but Hetzner in Germany, then we are an independent system.
<h3>What if I want a copy of all the emails?</h3>
Most email clients can set up rules on emails, you could get your systems to email you directly, then have a rule that puts the email away
in a folder (like you probably do already) and also sends a copy to the alert address at exceptionalemails.com that way you have
the original on file, and you get alerted to any missing emails.
<h3>Wouldn't it be better to use a dedicated monitoring tool?</h3>
Yes, everyone should set up a server running Nagios or another active monitoring tool, and use SNMP traps to spot errors
as soon as they happen directly. However if setting that lot up doesn't sound like fun it is very easy to get most
things to send an email when they are done. This is a simple and effective alternative if you don't yet need full active monitoring.
<h3>Will it let me know if my website is down?</h3>
No, we just tell you if an email didn't arrive, we don't monitor other things.
<h3>Is it free? Will it be free forever?</h3>
The software is free, our hosted service is free at the moment for up to 3 alerts but we will intend to add a subscription option
which will allow you to have unlimited alerts. The software itself is free forever.
<h3>What email address should I use for alerts?</h3>
Any address you like, however we would point out that if you are using an email address on a server that you are monitoring with
this service then that introduces a potential lack of independence - if your email server goes down and the backups fail to happen
and we notify you of the problem by emailing you then you won't get the notification (although you might notice that there is a
problem fairly quickly)
<h3>Can I have a notification as soon as a successfull email arrives?</h3>
No. That would be missing the point, If you want to know about the email when it happens then simply send it to yourself. We aim
to only email you when you need to care which means there must be stuff that you don't care about.
<h3>What happens if I get spam to my alert address?</h3>
Hopefully this won't be much of an issue as you won't use the "username+alertname@exceptionalemails.com" address for anything else,
we recommend you use the good words field to check the incoming emails for something that is pretty much always there
so a spam email won't match this and we would notify you on spam arriving because it would trigger the alert and not satisfy it.
You can then change the alertname, we reject every email that arrives for an invalid alertname so you won't see any spam directed
at the old alert address.
<h3>Can I have something more frequently than daily, how about an hourly option?</h3>
No. If you need that then you need more active monitoring of your infrastructure, you should be looking at SNMP and Nagios.
This is not a replacement for active monitoring, it is a simple and effective solution for people who don't need the
complexity of constant monitoring of events on their infrastructure.
<h3>What about privacy?</h3>
We have no intention whatsoever of selling your data to anyone, or putting adverts on the site (It isn't a good site
for adverts, the idea is you set up your alerts and never need to visit again). We don't store your password, just a hash of it.
We are not going to email you junk or let anyone else email you stuff, you will only get alerts you have asket for. (We are not
totally ruling out the possibility that one day we might need to send all users an email if there is something suitably important
to announce, but emailing you isn't part of our plan). When setting up your emails do have a think about whether they contain
sensitive information, don't send us a backup script log that includes passwords for example. Hostnames and filenames could also
be considered a minor risk, but it is your call. Remember we have the option to delete the body of the email on arrival
before we write it to disk.
<h3>Is it open source, can I run it myself?</h3>
This site is based on open source software specifically jQuery and Bootstrap with Python, PHP, MongoDB and Ubuntu Linux on the server.
The code for the site will be made available on GitHub under the AGPL3 licence soon, so yes you will be able to see and audit the source,
contribute fixes and run it yourself - however see the first point about reliability and independence. Running it on your own
infrastructure means it could be affected by the same problem that you want it to tell you about.

