#!/usr/bin/env bash

function lint_php_files() {
  local ARR_CHANGED_FILES=("$@");
  for changed_php_file in "${#ARR_CHANGED_FILES[@]}";
  do
    echo "Linting ${changed_php_file}";
    php -l -n "${changed_php_file}";
  done
}

function codesniff_changed_php_files() {
  local ARR_CHANGED_FILES=("$@");
  for changed_php_file in "${#ARR_CHANGED_FILES[@]}";
  do
    echo "Running phpcs against ${changed_php_file}";
    php $PWD/vendor/bin/phpcs -m -p -v "${changed_php_file}";
  done

}

function check_changed_php_files() {
  declare CHANGED_PHP_FILES;
  echo 'Looking for changed PHP files...';
  while IFS= read -r changed_php_file; do
    CHANGED_PHP_FILES+=( "${changed_php_file}" );
  done < <( git diff --name-only | grep -e '.php$' -e '.phtml$' -e '.inc$' )

  if [ ${#CHANGED_PHP_FILES[@]} -eq 0 ]; then
      echo "No changed PHP files found, moving on..."
  else
    lint_php_files ${#CHANGED_PHP_FILES[@]};
    codesniff_changed_php_files ${#CHANGED_PHP_FILES[@]};
  fi
}

check_changed_php_files;
