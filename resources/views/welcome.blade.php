<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SEA-MASTER-DATA</title>
    <link rel="icon" type="image/x-icon" href="/favicon.svg">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <script type="text/javascript" src="https://kit.fontawesome.com/42d5adcbca.js" async></script>
    <script type="text/javascript" src="https://buttons.github.io/buttons.js" async></script>
    <link rel="modulepreload" as="script" crossorigin href="/_nuxt/entry.44ee79b1.js">
    <link rel="preload" as="style" href="/_nuxt/entry.993a4a3b.css">
    <link rel="prefetch" as="image" type="image/svg+xml" href="/_nuxt/nucleo-icons.21030e24.svg">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/auth.fcb64ad4.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/AuthStore.4f83e0c3.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/fetch.dcc35a4e.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/index.fcf629fc.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/tslib.es6.0aa5e20b.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/useToast.26c9cdac.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/guest.86cbdc63.js">
    <link rel="prefetch" as="style" href="/_nuxt/404.dacc16e7.css">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/404.f07278a4.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/authentication.899ece66.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/components.abf4e438.js">
    <link rel="prefetch" as="style" href="/_nuxt/default.8731dc3e.css">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/default.9d37a755.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/SidenavList.da110140.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/NavStore.f50c6ed6.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/index.d921d2b3.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/useToast.9f44b793.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/logo-spotify.75cf2fcc.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/landing.c46de524.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/profile-layout.12a1c664.js">
    <link rel="prefetch" as="style" href="/_nuxt/rtl.15e908f4.css">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/rtl.95ffa2c3.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/vr-layout.39a26096.js">
    <link rel="prefetch" as="script" crossorigin href="/_nuxt/error-component.91f16e09.js">
    <link rel="stylesheet" href="/_nuxt/entry.993a4a3b.css">
    <script>"use strict";
        (() => {
            const a = window, e = document.documentElement, m = ["dark", "light"],
                c = window && window.localStorage && window.localStorage.getItem && window.localStorage.getItem("nuxt-color-mode") || "system";
            let n = c === "system" ? d() : c;
            const l = e.getAttribute("data-color-mode-forced");
            l && (n = l), i(n), a["__NUXT_COLOR_MODE__"] = {
                preference: c,
                value: n,
                getColorScheme: d,
                addColorScheme: i,
                removeColorScheme: f
            };

            function i(o) {
                const t = "" + o + "", s = "";
                e.classList ? e.classList.add(t) : e.className += " " + t, s && e.setAttribute("data-" + s, o)
            }

            function f(o) {
                const t = "" + o + "", s = "";
                e.classList ? e.classList.remove(t) : e.className = e.className.replace(new RegExp(t, "g"), ""), s && e.removeAttribute("data-" + s)
            }

            function r(o) {
                return a.matchMedia("(prefers-color-scheme" + o + ")")
            }

            function d() {
                if (a.matchMedia && r("").media !== "not all") {
                    for (const o of m) if (r(":" + o).matches) return o
                }
                return "light"
            }
        })();
    </script>
</head>
<body>
<div id="__nuxt"></div>
<script>window.__NUXT__ = {
        serverRendered: false,
        config: {
            public: {apiBaseUrl: "https:\u002F\u002Fmasterdata.thecloudgroup.tech\u002Fapi", isDemo: "0"},
            app: {baseURL: "\u002F", buildAssetsDir: "\u002F_nuxt\u002F", cdnURL: ""}
        },
        data: {},
        state: {}
    }</script>
<script type="module" src="/_nuxt/entry.44ee79b1.js" crossorigin></script>
</body>
</html>
