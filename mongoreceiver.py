#!/usr/bin/python
import smtpd
import asyncore
import email
import re
from pymongo import MongoClient
from bson.dbref import DBRef
from datetime import datetime
from pytz import timezone
import pytz
from sendfail import sendfail

#this is the daemon part of exceptional emails
#it recieves emails and if they are to a valid user they get put in the database
#if the user profile limits from addresses then it checks the from addresses
#anything else gets rejected

class CustomSMTPServer(smtpd.SMTPServer):

    def payloadtoarray(self,msg):
        payload=msg.get_payload()
        if msg.is_multipart():
            result=[]
            for part in payload:
                result.append(self.payloadtoarray(part))
	    return result
        else:
            return {msg.get_content_type():payload}

    def process_message(self, peer, mailfrom, rcpttos, data):
        #print ('Receiving message from:', peer)
        #print ('Message addressed from:', mailfrom)
        #print ('Message addressed to  :', rcpttos)
        #print ('Message length        :', len(data))
        #print (data)
        #we check in the database that the rcpttos is one valid user
        #otherwise fail with return "550 No such user"
        msg = email.message_from_string(data)#parse the headers
        print msg['subject'],rcpttos[0]
        sendto=rcpttos[0]
        #username is stuff to the left of the +
        if not "@" in sendto:
            email_id = exceptionalemails.erroremails.insert(post)
            return "550 Invalid email address"
        #we should accept postmaster address, or forward it somewhere else to be compliant
        if not "+" in sendto:
            email_id = exceptionalemails.erroremails.insert(post)
            return "550 Invalid address"
        username=sendto[:sendto.find('+')]#user is the bit up to the +
        alert=sendto[sendto.find('+')+1:sendto.find('@')]#alert is from the + to the @
        print username
        print alert
        post={"mailfrom":mailfrom,  "mailto":rcpttos[0], "subject":msg['subject'], "data":data ,"headers":msg.items(),"received":datetime.now()}
        post['payload']=self.payloadtoarray(msg)#this stores the parsed payload for PHP to render

        client = MongoClient()
        exceptionalemails = client.exceptionalemails
        emails=exceptionalemails.emails
        #lets see if we can add a bit to the post
        post['timestamp']=datetime.now()
        #can we find this user in the database?
        user=exceptionalemails.users.find_one({"username":username})
        if user:
            userref=DBRef("users",user['_id'])
            post['user']=userref
        else:
            #the email is not for any recognised user, record an error
            print "ERROR user not found"
            email_id = exceptionalemails.erroremails.insert(post)
            return "550 Invalid address, user not found"

        #is the alert found for that user?
        alertobj=exceptionalemails.alerts.find_one({"user":userref,"emailslug":alert,"pause":{'$ne':"1"}})
        if alertobj:
            alertref=DBRef("alerts",alertobj['_id'])
            post['alert']=alertref
        else:
            #the email is not for any recognised user, record an error
            email_id = exceptionalemails.erroremails.insert(post)
            print email_id
            print "ERROR alert not found"
            return "550 Invalid alert, alert not found"
 
        #now link it to an event today and see if it meets the criteria
        #we need to know what date it is now in the user's timezone
        userzone=timezone(user['timezone'])
        now=datetime.now(userzone)#arguably this should use now + 1 hour, or we should do two loops, now and now plus a bit
        userdate=now.strftime('%Y-%m-%d')#just the date part in our standard setup, not the user preference
        eventobj=exceptionalemails.events.find_one({"user":userref,"alert":alertref,"date":userdate})        
        #this really should find the event for the day
        if eventobj:
            #we can tie this email to an expectation, lets check it for good words and badwords
            #we do both checks, even if the first fails so we can do better error reporting
            #try:
            goodre=re.compile(alertobj['goodregex'])
            print alertobj['goodregex'],post['subject']
            if goodre.search(post['subject'] or goodre.search(post['data'])):
                eventobj['goodregex']=True
                #print "good match"
            else:
                eventobj['goodregex']=False
                #print "bad match"
            #except:
            #compile failed, lets complain about it a bit
            #    print "goodwords compile failed"
            try:
                badre=re.compile(alertobj['badregex'])
                if (alertobj['badregex']!='' and (badre.search(post['subject']) or badre.search(post['data']))):
                    eventobj['badregex']=True
                    #print "good bad match"
                else:
                    eventobj['badregex']=False
                    #print "bad bad match"
            except:
                #compile failed, lets complain about it a bit
                #lets see if the mail matches, first subject then body
                print "badwords compile failed "
                raise
            #should we unset the body before saving it?
            eventobj['complete']=True
            exceptionalemails.events.save(eventobj)
            email_id = emails.insert(post)
            emailref=DBRef("emails",email_id)
            eventobj['email']=emailref
            exceptionalemails.events.save(eventobj)
            if (eventobj['badregex'] or not eventobj['goodregex']):
                sendfail(eventobj,"Bad email")
                if ("deleteonfail" in alertobj['Options']):
                    post['data']=None
                    post['payload']=None
            else:
                if ("deleteonsuccess" in alertobj['Options']):
                    post['data']=None
                    post['payload']=None
        else:
            #we don't have an expectation created for today, but the email did arrive and we know what alert it belongs to.
            #it is possible that today isn't a day we were expecting this event to fire - or something is wrong with the cronjob that creates expectations
            #we could save it, but lets put it in a separate collection
            email_id = exceptionalemails.erroremails.insert(post)
            print email_id
        #depending on the alert preferences we might have to unset the body before saving it

        return

server = CustomSMTPServer(('0.0.0.0', 1025), None)

asyncore.loop()

