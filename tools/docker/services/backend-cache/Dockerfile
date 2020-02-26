ARG VARNISH_TAG="6.3"

FROM varnish:${VARNISH_TAG} as varnish-build

ARG BACKEND_NGINX_PORT_HTTP=8081

COPY --from=hairyhenderson/gomplate:v2.5.0-slim /gomplate /bin/gomplate

WORKDIR /build
COPY default.vcl ./

RUN /bin/gomplate -o /etc/varnish/default.vcl -f default.vcl

FROM varnish:${VARNISH_TAG} as varnish

WORKDIR /etc/varnish

COPY --from=varnish-build /etc/varnish .
