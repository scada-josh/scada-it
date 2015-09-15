# -- coding: utf-8 --

from flask import Flask, jsonify, request, json, make_response
from flask.ext.cors import CORS
from flask_restful import Resource, Api, reqparse, abort
from flask.ext.sqlalchemy import SQLAlchemy

from flask.ext.httpauth import HTTPBasicAuth
auth = HTTPBasicAuth()

@auth.get_password
def get_password(username):
    if username == 'miguel':
        return 'python'
    return None

@auth.error_handler
def unauthorized():
    return make_response(jsonify({'error': 'Unauthorized access'}), 401)



from datetime import datetime

from sqlalchemy import Boolean, Column
from sqlalchemy import DateTime ,Integer, String, Text
from sqlalchemy.ext.declarative import declarative_base
Base = declarative_base()


class Appointment(Base):
    __tablename__ = 'appointment'

    id = Column(Integer, primary_key=True)
    created = Column(DateTime, default=datetime.now)
    modified = Column(DateTime, default=datetime.now, onupdate=datetime.now)
    title = Column(String(255))
    start = Column(DateTime, nullable=False)
    end = Column(DateTime, nullable=False)
    allday = Column(Boolean, default=False)
    location = Column(String(255))
    description = Column(Text)

    @property
    def duration(self):
        # If the datetime type were supported natively on all database
        # management systems (is not on SQLite), then this could be a
        # hybrid_property, where filtering clauses could compare
        # Appointment.duration. Without that support, we leave duration as an
        # instance property, where appt.duration is calculated for us.
        delta = self.end - self.start
        return delta.days * 24 * 60 * 60 + delta.seconds

    def __repr__(self):
        return u'<{self.__class__.__name__}: {self.id}>'.format(self=self)

from datetime import timedelta
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker

 
app = Flask(__name__, static_url_path="")
api = Api(app)
# app.config['SQLALCHEMY_DATABASE_URI'] = 'mysql://root:@127.0.0.1:3306/flask_db'
# db = SQLAlchemy(app)

engine = create_engine('mysql://root:@127.0.0.1:3306/flask_db')
Base.metadata.create_all(engine)
Session = sessionmaker(bind=engine)
session = Session()
now = datetime.now()


"""
@api {get} /hello Test RESTful with Flask 
@apiName hello
@apiGroup TEST
@apiSampleRequest /hello
"""
@app.route('/hello')
def helloWorld():
    if db.session.query("1").from_statement("SELECT 1").all():
        # return 'It works.'
        temp = "It works"
    else:
        # return 'Something is broken.'
        temp = "Somthing is broken."
    return jsonify({'tasks': temp})
    # return jsonify({'tasks': 'hello'})


# TEST #
"""
@api {get} /hello_world Test RESTful with flask-restful 
@apiName hello_world
@apiGroup TEST
@apiSampleRequest /hello_world
"""
class HelloWorld(Resource):
    def get(self):
        return {'hello': 'world (GET)'}

    def post(self, todo_id):
    	# todos[todo_id] = request.form['data']
    	app.logger.debug('# todo_id #\n' + repr(todo_id))
        return {'hello': 'Hello'+ repr(todo_id) +' (POST)'}
"""
@api {get} /post_json Test receive JSON payload
@apiName post_json
@apiGroup TEST
@apiSampleRequest /post_json
"""
class postJSON(Resource):
    def get(self):
        return {'hello': 'world (GET)'}

    def post(self):
        # json_data = request.get_json(force=True)
        # un = json_data['username']
        # pw = json_data['password']

        # parser = reqparse.RequestParser()
        # parser.add_argument('username', type=str)
        # parser.add_argument('password', type=str)
        # args = parser.parse_args()
        # un = str(args['username'])
        # pw = str(args['password'])
        # return jsonify(u=un, p=pw)

        if request.headers['Content-Type'] == 'text/plain':
            return "Text Message: " + request.data
        elif request.headers['Content-Type'] == 'application/json':
            # return "JSON Message: " + json.dumps(request.json)
            json_data = request.get_json(force=True)
            un = json_data['username']
            pw = json_data['password']
            return jsonify(u=un, p=pw)
        elif request.headers['Content-Type'] == 'application/x-www-form-urlencoded':
            parser = reqparse.RequestParser()
            parser.add_argument('username', type=str)
            parser.add_argument('password', type=str)
            args = parser.parse_args()
            un = str(args['username'])
            pw = str(args['password'])
            return jsonify(u=un, p=pw)
        else:
            return "415 Unsupported Media Type ;)"
"""
@api {get} /login_auth Test Login Auth
@apiName login_auth
@apiGroup TEST
@apiSampleRequest /login_auth
"""
class loginAuth(Resource):
    decorators = [auth.login_required]
    def get(self):
        return {'hello': 'world (GET)'}
        
    def post(self):
        # json_data = request.get_json(force=True)
        # un = json_data['username']
        # pw = json_data['password']

        # parser = reqparse.RequestParser()
        # parser.add_argument('username', type=str)
        # parser.add_argument('password', type=str)
        # args = parser.parse_args()
        # un = str(args['username'])
        # pw = str(args['password'])
        # return jsonify(u=un, p=pw)

        if request.headers['Content-Type'] == 'text/plain':
            return "Text Message: " + request.data
        elif request.headers['Content-Type'] == 'application/json':
            # return "JSON Message: " + json.dumps(request.json)
            json_data = request.get_json(force=True)
            un = json_data['username']
            pw = json_data['password']
            return jsonify(u=un, p=pw)
        elif request.headers['Content-Type'] == 'application/x-www-form-urlencoded':
            parser = reqparse.RequestParser()
            parser.add_argument('username', type=str)
            parser.add_argument('password', type=str)
            args = parser.parse_args()
            un = str(args['username'])
            pw = str(args['password'])
            return jsonify(u=un, p=pw)
        else:
            return "415 Unsupported Media Type ;)"

"""
@api {get} /insert_appointment เพิ่ม Appointment
@apiName insertAppointment
@apiGroup Appointment
@apiSampleRequest /insert_appointment
"""
class insertAppointment(Resource):
    def get(self):
        session.add(Appointment(
            title='Important Meeting',
            start=now + timedelta(days=3),
            end=now + timedelta(days=3, seconds=3600),
            allday=False,
            location='The Office'))
        session.commit()
        return {'hello': 'world (GET)'}

    # def post(self, todo_id):
    #     # todos[todo_id] = request.form['data']
    #     app.logger.debug('# todo_id #\n' + repr(todo_id))
    #     return {'hello': 'Hello'+ repr(todo_id) +' (POST)'}




# Hello World #
api.add_resource(HelloWorld, '/hello_world/<string:todo_id>')
api.add_resource(postJSON, '/post_json')
api.add_resource(loginAuth, '/login_auth')

# CRUD Database #
api.add_resource(insertAppointment, '/insert_appointment')


if __name__ == '__main__':
    app.debug = True
    app.run(host='0.0.0.0', port=5000)