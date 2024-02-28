#!/usr/bin/env bash
if [[ -z "$1" ]]
then
    echo "You must pass a tag"
    exit 1
fi

docker build -t mitt .
docker tag mitt:latest "danmattern/mitt:${1}"
docker tag mitt:latest danmattern/mitt:latest
docker push "danmattern/mitt:${1}"
docker push "danmattern/mitt:latest"
