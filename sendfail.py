import smtplib
from pymongo import MongoClient
from bson.dbref import DBRef
from email.mime.text import MIMEText

def sendfail(event,reason):
    #we need to email the user about this event
    client = MongoClient()
    exceptionalemails = client.exceptionalemails
    users=exceptionalemails.users
    alerts=exceptionalemails.alerts
    events=exceptionalemails.events
    #print event
    #we need to find the user email address
    user=exceptionalemails.dereference(event['user'])
    alert=exceptionalemails.dereference(event['alert'])

    #prepare the email
    if (reason=="Late"):
        msg=MIMEText("We were expecting a valid email to be sent to %s+%s@exceptionalemails.com by %s but we don't have one." % ( user['username'] , alert['emailslug'], event['worrytime']),'plain')
    elif (reason=="Bad email"):
        msg=MIMEText("We received an invalid email to %s+%s@exceptionalemails.com.\n Click here to view details http://exceptionalemails.com/?action=object&collection=events&objectid=%s" % ( user['username'] , alert['emailslug'],event['_id']),'plain')
    #print user
    msg['To']=sendto=user['email']
    msg['Subject']="Exceptional Alert %s failed" % alert['AlertName']
    smtpObj = smtplib.SMTP('localhost')
    smtpObj.sendmail('nobody@exceptionalemails.com',msg['To'],msg.as_string())
