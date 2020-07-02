ARG NGINX_TAG="1.17.7-alpine"
# Get gomplate (https://docs.gomplate.ca/)
FROM hairyhenderson/gomplate:v2.8.0-slim as gomplate
FROM nginx:${NGINX_TAG} as backend-nginx-build

ARG BACKEND_NGINX_PORT_HTTP=8081

ARG APP_GROUP_NAME="app"
ARG PHP_SOCKET_DIR="/socket"
ARG PHP_SOCKET_FILE="app.sock"
ARG APP_CODE_DIR=/site/app

WORKDIR /build
# Copy the templates to the /build dir

COPY tools/docker/services/backend-nginx/ ./


COPY --from=gomplate /gomplate /bin/gomplate

RUN /bin/gomplate --input-dir=./ --output-dir=/etc/nginx/

FROM nginx:${NGINX_TAG} as backend-nginx

ARG APP_GROUP_ID=2001
ARG APP_GROUP_NAME="app"

WORKDIR /etc/nginx

COPY --from=backend-nginx-build /etc/nginx/ .

RUN addgroup --system --gid ${APP_GROUP_ID} "${APP_GROUP_NAME}"
RUN addgroup nginx ${APP_GROUP_NAME}
