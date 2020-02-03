#!/usr/bin/env bash

function lint-changed-php() {
  git diff --name-only | grep ".*\.php$" | xargs -I ChangedFile php -l ChangedFile;
}

lint-changed-php;
