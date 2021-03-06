#!/bin/bash

# Include extras
THISDIR=$(dirname $0)
. "$THISDIR/config.sh"
. "$THISDIR/helpers.sh"

# Input vars
DOMAIN=""
REPO_URL=""
BRANCH=""

# Reading args
while true
do
	case "$1" in
		--domain ) 
			DOMAIN="$2"
			shift 2
			;;
		--branch ) 
			BRANCH="$2"
			shift 2
			;;
		--url ) 
			REPO_URL="$2"
			shift 2
			;;
		* ) 
			break 
			;;
	esac
done

SITE_DIR="$WWW_DATA_DIR/$DOMAIN"
if [ ! -d "$SITE_DIR/.git" ]
then
	echo ">RETURN: 204 Can not find working copy"
	echo ">DATA: location $SITE_DIR"
	exit
fi	

cd "$SITE_DIR"
git-set-branch "$BRANCH"
git-pull "$REPO_URL" "$BRANCH"

# run setup/upgrade script
if [ -x "$SITE_DIR/update" ]
then
	"$SITE_DIR/update"
fi

# Report success
echo ">RETURN: 0 Pull has been successfully completed"
