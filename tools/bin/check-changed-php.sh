#!/usr/bin/env bash

function lint_php_files() {
  local ARR_CHANGED_FILES=("$@");
  for changed_php_file in "${ARR_CHANGED_FILES[@]}";
  do
    php -l -n "${changed_php_file}";
  done
}

function codesniff_changed_php_files() {
   local ARR_CHANGED_FILES=("$@");
  for changed_php_file in "${ARR_CHANGED_FILES[@]}";
  do
    echo "Running phpcs against ${changed_php_file}";
    php $PWD/vendor/bin/phpcs -m -p -v "${changed_php_file}";
  done

}

function check_changed_php_files() {
  declare CHANGED_PHP_FILES;
  while IFS= read -r changed_php_file; do
    CHANGED_PHP_FILES+=( "${changed_php_file}" );
  done < <( git diff --name-only | grep -e '.php$' -e '.phtml$' -e '.inc$' )

  lint_php_files ${CHANGED_PHP_FILES[@]};
  codesniff_changed_php_files ${CHANGED_PHP_FILES[@]};

}

check_changed_php_files;
