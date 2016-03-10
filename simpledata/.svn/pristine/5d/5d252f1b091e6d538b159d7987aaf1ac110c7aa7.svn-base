#!/bin/sh
source ~/.bash_profile

S0="${BASH_SOURCE[0]}"

DIRNAME="$( dirname "$S0")"

DIR="$( cd "$DIRNAME" && pwd)"

php  $DIR/run.php  --config oldcodes.cfg.xml  --src "$1"  --format console

find . -name style-report -mmin -1 -exec rm -rf {} \;
