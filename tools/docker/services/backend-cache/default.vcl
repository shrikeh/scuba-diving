# simple VCL example
vcl 4.1;

backend default {
  .host = "backend-nginx";
  .port = "{{ .Env.BACKEND_NGINX_PORT_HTTP }}";
}


sub vcl_recv {

    if (req.restarts == 0) {
        if (req.http.X-Forwarded-For) {
            set req.http.X-Forwarded-For = client.ip;
        }
    }

    // Add a Surrogate-Capability header to announce ESI support.
    set req.http.Surrogate-Capability = "abc=ESI/1.0";

    // Remove all cookies except the session ID.
    if (req.http.Cookie) {
        set req.http.Cookie = ";" + req.http.Cookie;
        set req.http.Cookie = regsuball(req.http.Cookie, "; +", ";");
        set req.http.Cookie = regsuball(req.http.Cookie, ";(PHPSESSID)=", "; \1=");
        set req.http.Cookie = regsuball(req.http.Cookie, ";[^ ][^;]*", "");
        set req.http.Cookie = regsuball(req.http.Cookie, "^[; ]+|[; ]+$", "");

        if (req.http.Cookie == "") {
            // If there are no more cookies, remove the header to get page cached.
            unset req.http.Cookie;
        }
    }

    if (req.method != "GET" && req.method != "HEAD") {
        return (pass);
    }
}


sub vcl_backend_response {
    // Check for ESI acknowledgement and remove Surrogate-Control header
    if (beresp.http.Surrogate-Control ~ "ESI/1.0") {
        unset beresp.http.Surrogate-Control;
        set beresp.do_esi = true;
    }
}

sub vcl_deliver {
    unset resp.http.Server;
    unset resp.http.X-Powered-By;
    unset resp.http.Via;
    unset resp.http.X-Varnish;

     if (obj.hits > 0) {
         set resp.http.X-Cache = "HIT";
     } else {
         set resp.http.X-Cache = "MISS";
     }
}
