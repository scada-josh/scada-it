define({ "api": [
  {
    "type": "get",
    "url": "/insert_appointment",
    "title": "เพิ่ม Appointment",
    "name": "insertAppointment",
    "group": "Appointment",
    "sampleRequest": [
      {
        "url": "http://localhost:5000/insert_appointment"
      }
    ],
    "version": "0.0.0",
    "filename": "./index.py",
    "groupTitle": "Appointment"
  },
  {
    "type": "get",
    "url": "/hello",
    "title": "Test RESTful with Flask",
    "name": "hello",
    "group": "TEST",
    "sampleRequest": [
      {
        "url": "http://localhost:5000/hello"
      }
    ],
    "version": "0.0.0",
    "filename": "./index.py",
    "groupTitle": "TEST"
  },
  {
    "type": "get",
    "url": "/hello_world",
    "title": "Test RESTful with flask-restful",
    "name": "hello_world",
    "group": "TEST",
    "sampleRequest": [
      {
        "url": "http://localhost:5000/hello_world"
      }
    ],
    "version": "0.0.0",
    "filename": "./index.py",
    "groupTitle": "TEST"
  },
  {
    "type": "get",
    "url": "/login_auth",
    "title": "Test Login Auth",
    "name": "login_auth",
    "group": "TEST",
    "sampleRequest": [
      {
        "url": "http://localhost:5000/login_auth"
      }
    ],
    "version": "0.0.0",
    "filename": "./index.py",
    "groupTitle": "TEST"
  },
  {
    "type": "get",
    "url": "/post_json",
    "title": "Test receive JSON payload",
    "name": "post_json",
    "group": "TEST",
    "sampleRequest": [
      {
        "url": "http://localhost:5000/post_json"
      }
    ],
    "version": "0.0.0",
    "filename": "./index.py",
    "groupTitle": "TEST"
  }
] });