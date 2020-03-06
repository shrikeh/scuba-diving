#!/usr/bin/env bash

function lint_php_files() {
  declare ARR_CHANGED_FILES=("$@");
  declare PASS_LINT=0;
  declare FILE_PASS=0;
  for changed_php_file in "${ARR_CHANGED_FILES[@]}";
  do
    printf "Linting %s\n" "${changed_php_file}";
    php -l -n "${changed_php_file}";
    FILE_PASS=$?;
    if [[ ${FILE_PASS} -ne 0 ]]; then
      echo $FILE_PASS;
      PASS_LINT=1;
    fi
  done

  return ${PASS_LINT};
}

# Codesniff changed php files
function codesniff_changed_php_files() {
  declare ARR_CHANGED_FILES=("$@");
  declare PASS_SNIFF=0;
  declare FILE_PASS=0;

  printf -v ZE_FILES_CHANGED "%s " "${ARR_CHANGED_FILES[@]}";

  echo "Running phpcs against changed files...";
  php "${PWD}/vendor/bin/phpcs" -w -p -v ${ZE_FILES_CHANGED};
  FILE_PASS=$?;
  if [[ ${FILE_PASS} -ne 0 ]]; then
    PASS_SNIFF=1;
  fi

  return ${PASS_SNIFF};
}

# Gather any changed PHP files and pass them to the linters/checkers
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
  done < <( git diff --name-only "${TARGET_BRANCH}" | grep -e '.php$' -e '.phtml$' -e '.inc$' )

  # Clean out files that have been moved or deleted
  for existing_php_file in "${CHANGED_PHP_FILES[@]}";
  do
    if [[ -f "${PWD}/${existing_php_file}" ]]; then
      EXISTING_PHP_FILES+=( "${existing_php_file}" );
    fi
  done

  if [[ ${#EXISTING_PHP_FILES[@]} -eq 0 ]]; then
      echo "No changed PHP files found, moving on..."
  else
    lint_php_files "${EXISTING_PHP_FILES[@]}" || { echo 'Lint failed' ; return 1; }
    codesniff_changed_php_files "${EXISTING_PHP_FILES[@]}" || { echo 'Codesniffer failed' ; return 2; }
  fi

  return 0;
}

check_changed_php_files;
