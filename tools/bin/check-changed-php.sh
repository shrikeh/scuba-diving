#!/usr/bin/env bash

function lint_php_files() {
  declare ARR_CHANGED_FILES=("$@");
  declare PASS_LINT=0;
  declare FILE_PASS=0;
  for changed_php_file in "${ARR_CHANGED_FILES[@]}";
  do
    echo "Linting ${changed_php_file}";
    php -l -n "${changed_php_file}";
    FILE_PASS=$?;
    if [[ ${FILE_PASS} -ne 0 ]]; then
      echo $FILE_PASS;
      PASS_LINT=1;
    fi
  done

  return ${PASS_LINT};
}

function codesniff_changed_php_files() {
  declare ARR_CHANGED_FILES=("$@");
  declare PASS_SNIFF=0;
  declare FILE_PASS=0;
  for changed_php_file in "${ARR_CHANGED_FILES[@]}";
  do
    echo "Running phpcs against ${changed_php_file}";
    php $PWD/vendor/bin/phpcs -w -p -v "${changed_php_file}";
    FILE_PASS=$?;
    if [[ ${FILE_PASS} -ne 0 ]]; then
      PASS_SNIFF=1;
    fi
  done

  return ${PASS_SNIFF};
}

function check_changed_php_files() {
  declare CHANGED_PHP_FILES;
  declare EXISTING_PHP_FILES;
  declare TARGET_BRANCH='develop';
  declare CURRENT_BRANCH_NAME="$(git rev-parse --abbrev-ref HEAD)";

  if [[ "${CURRENT_BRANCH_NAME}" == 'develop' ]]; then
    TARGET_BRANCH='master';
  fi

  echo 'Looking for changed PHP files...';
  while IFS= read -r changed_php_file; do
    CHANGED_PHP_FILES+=( "${changed_php_file}" );
  done < <( git diff --name-only "${TARGET_BRANCH}" HEAD~  | grep -e '.php$' -e '.phtml$' -e '.inc$' )

  # Clean out files that have been moved or deleted
  for existing_php_file in "${CHANGED_PHP_FILES[@]}";
  do
    if [[ -f "${existing_php_file}" ]]; then
      EXISTING_PHP_FILES+=( "${existing_php_file}" );
    fi
  done

  if [[ ${#EXISTING_PHP_FILES[@]} -eq 0 ]]; then
      echo "No changed PHP files found, moving on..."
  else
    lint_php_files "${EXISTING_PHP_FILES[@]}" || { echo 'Lint failed' ; return 1; }
    codesniff_changed_php_files "${EXISTING_PHP_FILES[@]}" || { echo 'Codesniffer failed' ; return 2; }
  fi
}

check_changed_php_files;
