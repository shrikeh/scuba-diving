#!/usr/bin/env bash

function create_root_key() {
  local ROOT_KEY_PATH="${1}";
  echo "Generating root key to ${ROOT_KEY_PATH}\n";
  openssl genrsa -out "${ROOT_KEY_PATH}" 4096;
}

function generate_csr() {
  local ROOT_KEY_PATH="${1}";
  local ROOT_CA_CSR="${2}";
  echo "Generating root csr from ${ROOT_KEY_PATH} to ${ROOT_CA_CSR}\n";

  openssl req \
    -new -key "${ROOT_KEY_PATH}" \
    -out "${ROOT_CA_CSR}" -sha256 \
    -subj '/C=UK/L=London/O=Shrikeh.net/CN=Swarm Secret Example CA';
}

function sign_certificate() {
  local ROOT_CA_CSR="${1}";
  local ROOT_CA_KEY="${2}";
  local ROOT_CA_CERT="${3}";
  local ROOT_CA_CONF="${4}";

  openssl x509 -req  -days 3650  -in "${ROOT_CA_CSR}" \
    -signkey "${ROOT_CA_KEY}" -sha256 -out "${ROOT_CA_CERT}" \
    -extfile "${ROOT_CA_CONF}" -extensions \
    root_ca;
}

function generate_site_key() {
  local SITE_KEY_PATH="${1}";

  echo "Generating site key to ${SITE_KEY_PATH}\n";

  openssl genrsa -out "${SITE_KEY_PATH}" 4096;
}

function generate_site_certificate() {
  local SITE_KEY_PATH=${1};
  local SITE_CERT_CSR=${2};

  echo "Generating site certificate from ${SITE_KEY_PATH} to ${SITE_CERT_CSR}\n";

  openssl req -new -key "${SITE_KEY_PATH}" -out "${SITE_CERT_CSR}" -sha256 \
   -subj '/C=UK/L=London/O=Shrikeh.net/CN=localhost';
}

function sign_site_certificate() {
  local SITE_CERT_PATH="${1}";
  local SITE_CERT_CSR="${2}";
  local ROOT_CA_CRT="${3}";
  local ROOT_CA_KEY="${4}";
  local SITE_CONF_PATH="${5}";

  echo "Signing site certificate ${SITE_CERT_PATH} (certificate ${SITE_CERT_CSR}) with ${ROOT_CA_CRT} (key: ${ROOT_CA_KEY})";

  openssl x509 -req -days 750 -in "${SITE_CERT_CSR}" -sha256 \
    -CA "${ROOT_CA_CRT}" -CAkey "${ROOT_CA_KEY}"  -CAcreateserial \
    -out "${SITE_CERT_PATH}" -extfile "${SITE_CONF_PATH}" -extensions server;
}

function generate_tls_keys() {
  local ROOT_KEY_PATH="${1:-./root-ca.key}";

  local ROOT_CA_CSR="${2:-./root-ca.csr}";
  local ROOT_CA_KEY="${3:-./root-ca.key}";
  local ROOT_CA_CERT="${4:-./root-ca.crt}";

  local ROOT_CA_CONF="${5:-/Users/barney.hanlon/Workspace/barneys-diving-kit.shrikeh.net/tools/certs/root-ca.cnf}";

  local SITE_KEY_PATH="${6:-./site.key}";
  local SITE_CERT_PATH="${7:-./site.crt}";
  local SITE_CERT_CSR="${7:-./site.csr}";

  local SITE_CONF_PATH="${8:-/Users/barney.hanlon/Workspace/barneys-diving-kit.shrikeh.net/tools/certs/site.cnf}";

  create_root_key "${ROOT_KEY_PATH}";
  generate_csr "${ROOT_KEY_PATH}" "${ROOT_CA_CSR}";
  sign_certificate "${ROOT_CA_CSR}" "${ROOT_CA_KEY}" "${ROOT_CA_CERT}" "${ROOT_CA_CONF}";
  generate_site_key "${SITE_KEY_PATH}";
  generate_site_certificate "${SITE_KEY_PATH}" "${SITE_CERT_CSR}";
  sign_site_certificate "${SITE_CERT_PATH}" "${SITE_CERT_CSR}" "${ROOT_CA_CERT}" "${ROOT_CA_KEY}" "${SITE_CONF_PATH}";
}

generate_tls_keys;
