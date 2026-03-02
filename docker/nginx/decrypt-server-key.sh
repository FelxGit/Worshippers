#!/bin/bash

echo '############'
echo 'decrypt-server-key.sh'
echo '############'

# Read the passphrase from the Docker secret
PASSPHRASE=$(cat /run/secrets/mypassphrase.txt)

# It's a good idea not to echo the passphrase for security reasons, so this line should be removed or commented out.
# echo "PASSPHRASE: $PASSPHRASE" # Don't print the passphrase!

echo '############'
echo $PASSPHRASE

# Decrypt the private key using the passphrase
openssl rsa -aes256 -in /etc/nginx/ssl/server.key -passin pass:"$PASSPHRASE" -out /etc/nginx/ssl/server.key.decrypted

# Replace the encrypted key with the decrypted one
mv /etc/nginx/ssl/server.key.decrypted /etc/nginx/ssl/server.key

# Start Nginx
nginx -g 'daemon off;'
