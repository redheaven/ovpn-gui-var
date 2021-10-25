#!/bin/bash
. /etc/openvpn/scripts/config.sh
. /etc/openvpn/scripts/functions.sh
CURL='/usr/bin/curl'
username=$(echap "$username")
password=$(echap "$password")

# Determine if we are using 2 factor authentication for this user

user_2factor=$(mysql -h$HOST -P$PORT -u$USER -p$PASS $DB -sN -e "SELECT user_2factor FROM user WHERE user_id = '$username'")
echo "$user_2factor"

# Authentication
user_pass=$(mysql -h$HOST -P$PORT -u$USER -p$PASS $DB -sN -e "SELECT user_pass FROM user WHERE user_id = '$username' AND user_enable=1 AND (TO_DAYS(now()) >= TO_DAYS(user_start_date) OR user_start_date IS NULL) AND (TO_DAYS(now()) <= TO_DAYS(user_end_date) OR user_end_date IS NULL)")




# Check the user
if [ "$user_pass" == '' ]; then
  echo "$username: bad account."
  exit 1
fi

if [ "$user_2factor" == '1' ]; then
  secret_code=$(mysql -h$HOST -P$PORT -u$USER -p$PASS $DB -sN -e "SELECT user_2factor_scode FROM user WHERE user_id = '$username'")
  pin_number=${password: -6}

  # you can store the result in a variable
  google_authenticate=$($CURL -s "http://googleauth/validate.php?Pin=${pin_number}&SecretCode=${secret_code}")
  echo "Authenticator API:" + $google_authenticate

  result=$(php -r "if(password_verify('${password::-6}', '$user_pass') == true && '$google_authenticate' == 'True') { echo 'ok'; } else { echo 'ko'; }")
else
  # no need to do 2 step authentication - use only passwod
  result=$(php -r "if(password_verify('$password', '$user_pass') == true) { echo 'ok'; } else { echo 'ko'; }")
fi



if [ "$result" == "ok" ]; then
  echo "$username: authentication ok."
  exit 0
else
  echo "$username: authentication failed."
  exit 1
fi
