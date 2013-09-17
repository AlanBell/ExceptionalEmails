#!/usr/bin/python
#This component looks through all the incompleted events and sees if they are past their worry time
#if they are late it sets the status as a fail and sets the event to completed
#if an email arrives late, it will be associated with the event, but it is still a fail with reason late
#there can be multiple fail reasons


from pymongo import MongoClient
from bson.dbref import DBRef
from datetime import datetime
from pytz import timezone
import pytz
from sendfail import sendfail

client = MongoClient()
exceptionalemails = client.exceptionalemails
users=exceptionalemails.users
alerts=exceptionalemails.alerts
events=exceptionalemails.events
fmt = '%Y-%m-%d %H:%M:%S'

for event in events.find({"complete":{'$ne':True}}):
    #we don't care if they are past or future yet, 
   try:
    if event['user']:
        user=exceptionalemails.dereference(event['user'])
        if user:
            alert=exceptionalemails.dereference(event['alert'])
            #print 'Processing event "%s" for user "%s"' % (alert['AlertName'],user['username'])
            eventzone=timezone(event['timezone'])#fairly unlikely that the user timezone and event timezone are different, but the user could change their zone at some point and historical events should keep their zone
            now=datetime.now(eventzone)
            userdate=now.strftime(fmt)
            worrydt=datetime.strptime(event['date'] +' '+ event['worrytime'] ,'%Y-%m-%d %H:%M' )
            #print "worrytime is %s" % (eventzone.localize(worrydt) )
            #print 'datetime now in their zone is %s' % userdate
            timetoworry=eventzone.localize(worrydt)-now
            #print "timedelta is %s" % (timetoworry.total_seconds())
            #there probably won't be any emails referencing this event (there could be later, if one arrives late - but it is still a fail)
            #the only important thing is whether now is after the worrytime
            if timetoworry.total_seconds()<0:
               #we should now be worried, lets complete this event as a fail, and notify the user
               print "Sending a fail, event %s is late" % event['_id']
               events.update({'_id':event['_id']},{'$set':{'late':True,'complete':True}})
               sendfail(event,"Late")
               print
        else:
            print "ERROR Event %s has no user" % event['_id']
            print
   except Exception as e:
      print "ERROR  %s processing alert %s " % (e, alert['_id'])
