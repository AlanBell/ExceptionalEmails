#!/usr/bin/python
#This component creates the daily expectation to be met by an email
#we itterate through all the alerts
#for each alert, we look at the user timezone to figure out the date "today" - perhaps the date in one hour from now, so it is there for
#midnight, some emails might well arrive very shortly after midnight
#then we do an upsert to create an event for today
#it must run at least every 15 minutes as there are 15 minute offset timezones
#if performance is an issue it could select on timezone, but that would need a fairly fancy select and would only make thinks 24 times
#faster (assuming utterly false assumption that people are distributed
#around the globe evenly.

from pymongo import MongoClient
from bson.dbref import DBRef
from datetime import datetime
from pytz import timezone
import pytz

client = MongoClient()
exceptionalemails = client.exceptionalemails
users=exceptionalemails.users
alerts=exceptionalemails.alerts
events=exceptionalemails.events
fmt = '%Y-%m-%d'
for alert in alerts.find({"pause":{'$ne':"1"}}):
   try:
    if alert['user']:
        user=exceptionalemails.dereference(alert['user'])
        if user:
            #print 'Processing alert "%s" for user "%s"' % (alert['AlertName'],user['username'])
            #print 'user is in timezone %s' %  user['timezone']
            userzone=timezone(user['timezone'])
            now=datetime.now(userzone)#arguably this should use now + 1 hour, or we should do two loops, now and now plus a bit
            userdate=now.strftime(fmt)
            #print 'Date now in their zone is %s' % userdate
            #now create the event for this user, for this alert
            #for today
            event={}
            event['user']=DBRef("users",user['_id'])
            event['alert']=DBRef("alerts",alert['_id'])
            event['timezone']=user['timezone']
            event['worrytime']=alert['worrytime']
            event['date']=userdate
            #print "Creating:", event
            #is this a date for which we are expecting this alert to fire?
            weekday=now.weekday()
            events.update({'user':event['user'],'alert':event['alert'],'date':event['date']},{'$set':event},True)
        else:
            print "ERROR Alert %s has no user" % alert['_id']
   except Exception as e:
      print "ERROR  %s processing alert %s " % (e, alert['_id'])
