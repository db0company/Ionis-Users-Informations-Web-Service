#!/bin/sh

my_login="exampl_e"
my_ppp_password="2q4xfcc3"

if [ $# -ne 1 ]
then
    echo "usage: "$0" login" >&2
    exit 2
else
    wget get "http://ws.paysdu42.fr/INI/?action=get_promo&auth_login="$my_login"&auth_password="$my_ppp_password"&login="$1 -O - -o /dev/null | grep "promo=" | cut -d= -f2
fi
