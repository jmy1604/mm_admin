#!/bin/bash

HOSTNAME="127.0.0.1"
PORT="3306"
USERNAME="root"
PASSWORD=""
mysql -h${HOSTNAME} -P${PORT} -u${USERNAME} -p${PASSWORD} < init_db.sql
