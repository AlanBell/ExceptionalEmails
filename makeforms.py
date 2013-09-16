#!/usr/bin/python
# coding: utf-8
from pymongo import MongoClient
from bson.dbref import DBRef

client = MongoClient()
exceptionalemails = client.exceptionalemails

design=exceptionalemails.design
event={"form":"events",
"type":"form",
"readlayout":
  {"type":"panel",
    "title":[{"type":"string","content":"Event for "},{"type":"docref-text","content":"alert-AlertName","fieldtype":"raw"}],
    "body":[
            {"type":"text","content":"date","title":"Event Date"},
            {"type":"text","content":"worrytime","title":"Worry Time"},
            {"type":"docref-datetime", "content":"email-received","title":"Received Time"},
            {"type":"booleanYN","content":"late","title":"Was it late?"},
            {"type":"booleanTF","content":"goodregex"},
            {"type":"booleanTF","content":"badregex"},
            {"type":"docref","content":"email-subject","title":"Email Link"},
           ]
    },
}
design.update({"form":"events"},event,True)


email={"form":"emails",
"type":"form",
"readlayout":
[
  {
    "type":"panel",
    "title": {"type":"string", "content":"Metadata"},
    "body": [
      {"type":"datetime", "content":"received"},
      {"type":"text","content": "subject"},
    ]
  },
  {
    "type":"panel",
    "title": {"type":"string", "content":"Email Body"},
    "body":  [
      {"type":"string","content": "The rendering here is a work in progress, it will support html and plain text mails and will render them safely to avoid XSS.<hr>"},
      {"type":"email", "content":"payload","fieldtype":"raw"}
    ]
  }
]
}
design.update({"form":"emails"},email,True)
