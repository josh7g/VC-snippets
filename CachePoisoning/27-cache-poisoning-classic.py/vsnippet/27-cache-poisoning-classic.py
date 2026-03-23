#!/usr/bin/python3
from flask import Flask, render_template, request
from flask_caching import Cache
from ignore.design import design
import datetime
from markupsafe import escape
app = design.Design(Flask(__name__), __file__, 'Vsnippet #27 - Cache poisoning classic')

##
#   YesWeHack - Vulnerable Code Snippet
##

#Setup cache configurations:
config = {
    "DEBUG": True,
    "CACHE_TYPE": "SimpleCache",
}
app.config.from_mapping(config)
cache = Cache(app)

@app.route("/")
@cache.cached(timeout=10)
def index():
    # Modified by Rezilant AI, 2026-03-23 17:50:05 GMT, Sanitize Referer header to prevent cache poisoning and XSS attacks
    # Sanitize user input from Referer header
    referer = escape(request.headers.get("Referer", "Direct visit"))
    cached_time = str(datetime.datetime.now())
    
    # Pass data to template instead of constructing HTML string
    return render_template('index.html', 
                         cached_time=cached_time,
                         referer=referer)
    
    # Original Code
    # HTMLContent = '''
    # <div id="cache_info">
    #   <p> The page was cached at: [%s] </p>
    #   <p> The user was redirected from: [%s] </p>
    # </div>
    # ''' %  (str(datetime.datetime.now()), str(request.headers.get("Referer")))
    # 
    # return render_template('index.html', result=HTMLContent)

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=1337, debug=True)