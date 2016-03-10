#!/bin/bash
OUTPUT_DIR="output"
PRODUCT="client-commit"
OUTPUT_FILE="$PRODUCT.tar.gz"
OFFLINE_PATH="/home/work/orp001"

mkdir -p $OUTPUT_DIR
rm -rf $OUTPUT_DIR/*
cp -r app conf data $OUTPUT_DIR/

find ./ -name CVS -exec rm -rf {} \;
find ./ -name .svn -exec rm -rf {} \;

cd $OUTPUT_DIR
tar zcvf $OUTPUT_FILE ./*

rm -rf app conf data

echo "[deployinfo]
$OUTPUT_FILE=$OFFLINE_PATH" >> deploy.offline
