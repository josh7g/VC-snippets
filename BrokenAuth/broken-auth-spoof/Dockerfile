FROM golang:latest

#Install and update system dependencies
RUN apt update -y; apt install -y supervisor

#Prepare and setup the working directory
RUN mkdir -p /app
WORKDIR /app
COPY vsnippet .
COPY config/supervisord.conf /etc/supervisord.conf

# Modified by Rezilant AI, 2025-11-22 10:11:41 GMT, Create non-root user and set ownership to prevent running as root
RUN useradd -m -u 1000 appuser && \
    chown -R appuser:appuser /app

EXPOSE 1337

# Modified by Rezilant AI, 2025-11-22 10:11:41 GMT, Switch to non-root user before ENTRYPOINT
USER appuser

# Original Code
# ENTRYPOINT [ "/usr/bin/supervisord", "-c", "/etc/supervisord.conf" ]
ENTRYPOINT [ "/usr/bin/supervisord", "-c", "/etc/supervisord.conf" ]