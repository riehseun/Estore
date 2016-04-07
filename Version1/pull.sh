#!/bin/bash
rsync -ar --delete-after /var/www/html/estore/ ./estore -i
