ARG VARNISH_TAG="6.3"
FROM hairyhenderson/gomplate:v2.8.0-slim as gomplate
FROM varnish:${VARNISH_TAG} as varnish-build

ARG BACKEND_NGINX_PORT_HTTP=8081

COPY --from=gomplate /gomplate /bin/gomplate

WORKDIR /build
COPY default.vcl ./

RUN /bin/gomplate -o /etc/varnish/default.vcl -f default.vcl

FROM varnish:${VARNISH_TAG} as varnish

WORKDIR /etc/varnish

COPY --from=varnish-build /etc/varnish .
