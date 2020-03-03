ARG PAGESPEED_TAG="1.13.35.2-alpine3.8"
FROM pagespeed/nginx-pagespeed:${PAGESPEED_TAG} as frontend-nginx-build

ARG BACKEND_CACHE_PORT_HTTP=80
ARG FRONTEND_NGINX_PORT_HTTP=8080
ARG FRONTEND_NGINX_PORT_HTTPS=8443
ARG FRONTEND_PAGESPEED_FILE_CACHE

ARG FRONTEND_NGINX_TLS_CERTIFICATE=certificate.pem
ARG FRONTEND_NGINX_TLS_KEY=key.pem
ARG FRONTEND_NGINX_TLS_DHPARAMS=dhparams.pem

WORKDIR /build
# Copy the templates to the /build dir
COPY tools/docker/services/frontend-nginx/conf ./


# Get gomplate (https://docs.gomplate.ca/)
COPY --from=hairyhenderson/gomplate:v2.5.0-slim /gomplate /bin/gomplate

RUN /bin/gomplate --input-dir=./ --output-dir=/etc/nginx/

FROM pagespeed/nginx-pagespeed:${PAGESPEED_TAG} as frontend-nginx
ARG FRONTEND_PAGESPEED_FILE_CACHE

RUN mkdir -p ${FRONTEND_PAGESPEED_FILE_CACHE}


COPY docs/metrics /metrics

WORKDIR /etc/nginx

COPY --from=frontend-nginx-build /etc/nginx/ .
