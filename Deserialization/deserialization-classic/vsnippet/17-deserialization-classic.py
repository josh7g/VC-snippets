#!/usr/bin/python3
from flask import Flask, render_template, Response, request
from datetime import date
import base64 as b64
import pickle
import json  # Modified by Rezilant AI, 2025-11-21 21:43:06 GMT, Added JSON import for secure serialization

##
# YesWeHack - Vulnerable Code Snippet
##

app = Flask(__name__)


def User_RedirectTo(d):
    ##Handle the user data and redirect
    #Code...
    return "<h2>Redirecting you!</h2>"

class CreateData(object,):
#Create an object to store user data:
    def __init__(self, id, name, date):
        self.id = id
        self.name = name
        self.date = date

    def __str__(self):
        return str(self.__dict__)


@app.route('/', methods = ['GET', 'POST'])
def index():
    resp = Response()
    
    #Get user data from cookie:
    dataCookie = request.cookies.get('userData')

    #Verify & deserialize user data:
    if dataCookie is not None:
        try:
            # Modified by Rezilant AI, 2025-11-22 09:42:08 GMT, Replaced insecure pickle deserialization with safe JSON deserialization
            data = b64.b64decode(bytes(dataCookie, 'UTF-8')).decode('UTF-8')
            user_data = json.loads(data)  # Safe JSON deserialization
            
            # Validate the expected structure
            if not all(k in user_data for k in ['id', 'name', 'date']):
                raise ValueError("Invalid data structure")
                
            return User_RedirectTo(user_data)
            # Original Code
            # data = b64.b64decode(bytes(dataCookie, 'UTF-8'))
            # data = pickle.loads(data)
            # return User_RedirectTo(data)
        
        except:
            return render_template('index.html', result="<h2>Invalid data...</h2>")

    else:
        # Modified by Rezilant AI, 2025-11-22 09:42:08 GMT, Replaced object serialization with JSON dictionary serialization
        user_data = {
            'id': None,
            'name': 'guest',
            'date': date.today().strftime('%d/%m/%Y')
        }
        json_data = json.dumps(user_data)
        resp.set_cookie('userData', b64.b64encode(json_data.encode('UTF-8')).decode('UTF-8'))
        resp.data = render_template('index.html', result="")
        # Original Code
        # newData = CreateData(None, 'guest', date.today().strftime('%d/%m/%Y'))
        # newData = bytes(str(newData), 'UTF-8')
        # resp.set_cookie('userData', b64.b64encode(newData))
        
        return resp

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=1337, debug=True)