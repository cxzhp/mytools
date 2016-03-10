#!/bin/bash

MODULE_NAME="simpledata"

OUTPUT_DIR="output"
APP_DIR="app"
PRODUCT_DIR="mis"
ACTION_PRODUCT_DIR="actions/"$MODULE_NAME
OUTPUT_FILE="mis_ui_"$MODULE_NAME".tar.gz"

mkdir -p $OUTPUT_DIR
rm -rf $OUTPUT_DIR/*


mkdir -p $OUTPUT_DIR/$APP_DIR/$PRODUCT_DIR/$ACTION_PRODUCT_DIR
cp  actions/* $OUTPUT_DIR/$APP_DIR/$PRODUCT_DIR/$ACTION_PRODUCT_DIR/


cd $OUTPUT_DIR
find ./ -type d -name ".svn"|xargs rm -rf {}
#without build
####################
rm -rf easywireless
rm -rf phpcheckstyle_without_namespace
####################
tar zcvf $OUTPUT_FILE $APP_DIR/*

rm -rf $APP_DIR

cd ..
