from flask import Flask, render_template, request
import os, ipaddress
from ignore.design import design
import subprocess

app = design.Design(Flask(__name__), __file__, 'Vsnippet - Classic command injection')

##
# YesWeHack - Vulnerable code snippets
##


@app.route('/', methods = ['GET', 'POST'])
def index():
    if request.method == "GET":
        return render_template('index.html', result="")
    
    elif request.method == "POST":
        method = request.form.get("method")
        if method is None or method == "":
            return render_template('index.html', result="The post parameter 'method' is missing in the request")
        
        # Modified by Rezilant AI, 2026-03-23 17:39:07 GMT, replaced os.popen() with subprocess.run() to prevent command injection
        result = subprocess.run(
            ['curl', f'http://localhost:1337/{method}'],
            capture_output=True,
            text=True,
            timeout=5
        ).stdout
        return render_template('index.html', result=result)
        
        # Original Code
        # return render_template('index.html', result=os.popen(f"curl 'http://localhost:1337/{method}'").read())
    
    return "Unsupported request method"


# Dummy system health checker
@app.route('/health')
def health():
    try:
        if ipaddress.ip_address(request.remote_addr).is_loopback:
            return "The health of the system is quite good!"
    except:
        pass
    return "Unauthorized"        


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=1337, debug=True)