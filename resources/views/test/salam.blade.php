<html>

<head>

    <style>
        @font-face {
            font-weight: normal;
            font-style: normal;
            font-family: 'IRANSansWeb';
            src: url('{{ URL::asset('fonts/theme2/IRANSansWeb.eot') }}');
            src: url('{{ URL::asset('fonts/theme2/IRANSansWeb.eot') }}') format('embedded-opentype'), url('{{ URL::asset('fonts/theme2/IRANSansWeb.woff2') }}') format('woff2'), url('{{ URL::asset('fonts/theme2/IRANSansWeb.woff') }}') format('woff'), url('{{ URL::asset('fonts/IRANSansWeb.ttf') }}');
        }

        .main {
            direction: rtl;
            font-family: IRANSansWeb;
            /*padding: 70px;*/
            overflow-x: hidden;
        }

        .text {
            margin-left: auto;
            margin-right: auto;
            width: 200px;
        }

        .big_element {
            margin-left: auto;
            margin-right: auto;
            margin-top: 50px;
            width: 50%;
            text-align: justify;
            border: 5px dashed black
        }

        .line {
            width: 70%;
            height: 2px;
            border-bottom: 2px solid var(--koochita-light-green);
            margin-right: auto;
            margin-left: auto;
        }
    </style>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            // $.ajax({
            //     type: 'post',
            //     url: 'http://192.168.0.106/eghamat/public/api/activation_code',
            //     data: {
            //         'phone': '09214915905'
            //     },
            //     success: function(res) {
            //         console.log('====================================');
            //         console.log(res);
            //         console.log('====================================');
            //     }
            // });


            // $.ajax({
            //     type: 'post',
            //     url: 'http://192.168.0.106/eghamat/public/api/login',
            //     data: {
            //         'phone': '09214915905',
            //         'verification_code': '1111'
            //     },
            //     success: function(res) {
            //         console.log('====================================');
            //         console.log(res);
            //         console.log('====================================');
            //     }
            // });


            // $.ajax({
            //     type: 'get',
            //     url: 'http://myeghamat.com/api/asset',
            //     headers: {
            //         'Accept': 'application/json',
            //         'Content-Type': 'application/json',
            //         "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZTUxMDZjOTNiNGEzOTc5ODdmNjI0ZDllMTYyMGFiNzNkNjM0Y2IzOTA2YTRlNThmOTY3NGQxZDliMzVjYmY5OTE3MmUyMGUzODAxYjBmOTAiLCJpYXQiOjE2ODUxODQyNjcuOTkzNDE3LCJuYmYiOjE2ODUxODQyNjcuOTkzNDIyLCJleHAiOjE3MTY4MDY2NjcuNzgzODkzLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ieMJMIypKQF-u6-RbyyjQ-IuZsK31o92D7pIh4YHAX0GD8iKUKF9dnZ0cWDtA85cGcNVxTsdL908fmDKB8IyU5ZzfOQC1KBTMaQ8d8-uXafnJfJHFs9sJ8DDap1yoCn7FwHh-ICOYwSiWcZmwcbMYXyA-Vr8ltALZgSSqKHNLw0AfxOd2WColEGpudpnRb5ZSu59t6WnjUMuTlW1qQKjUv2lcuIQMsdTSOIiEDLfAYU1uReWKobNzv3VgiLINLfKNRfopJU7rSWE9qeC5RTXIxh5hR-ojp64hC_vO4KAMJMDjJEtB6y6TQczDSqU7GCupuY5ff2ZNHrKKcAVCrKhhenhWfViJvDVpYdEdyoI_8nvhlCpAVFSvDn6M344RuoTlPJzg8UHsEc-anEO16ihff3VAbo41vy0ZA7WPGWi8JxDajJeMPcl_IGtGwMkTPbNM2NP45-zQWjdr54GgEL2b11TwK_DUXW07RKCcozN1akuOw86q2O86J23s16PtcrVl3_iGhwjrHfOFUNvBDukenKcinB6Dd4tgz6aFacOCeIJSphJzcI7UCKIEyl9VBNIZDAQMqQBq_MyITTslq7DiuikcapUfBlZCnQvWgTOBfinQmo-Tub3ocAZjted5EBnU8vZncLRMftqahLNpmxyPLbgAQf2RvIT9n5Jko_4Io8"
            //     },
            //     success: function(res) {
            //         console.log('====================================');
            //         console.log(res);
            //         console.log('====================================');
            //     }
            // });

            $.ajax({
                type: 'get',
                url: 'http://myeghamat.com/api/asset/1/form',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZTUxMDZjOTNiNGEzOTc5ODdmNjI0ZDllMTYyMGFiNzNkNjM0Y2IzOTA2YTRlNThmOTY3NGQxZDliMzVjYmY5OTE3MmUyMGUzODAxYjBmOTAiLCJpYXQiOjE2ODUxODQyNjcuOTkzNDE3LCJuYmYiOjE2ODUxODQyNjcuOTkzNDIyLCJleHAiOjE3MTY4MDY2NjcuNzgzODkzLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ieMJMIypKQF-u6-RbyyjQ-IuZsK31o92D7pIh4YHAX0GD8iKUKF9dnZ0cWDtA85cGcNVxTsdL908fmDKB8IyU5ZzfOQC1KBTMaQ8d8-uXafnJfJHFs9sJ8DDap1yoCn7FwHh-ICOYwSiWcZmwcbMYXyA-Vr8ltALZgSSqKHNLw0AfxOd2WColEGpudpnRb5ZSu59t6WnjUMuTlW1qQKjUv2lcuIQMsdTSOIiEDLfAYU1uReWKobNzv3VgiLINLfKNRfopJU7rSWE9qeC5RTXIxh5hR-ojp64hC_vO4KAMJMDjJEtB6y6TQczDSqU7GCupuY5ff2ZNHrKKcAVCrKhhenhWfViJvDVpYdEdyoI_8nvhlCpAVFSvDn6M344RuoTlPJzg8UHsEc-anEO16ihff3VAbo41vy0ZA7WPGWi8JxDajJeMPcl_IGtGwMkTPbNM2NP45-zQWjdr54GgEL2b11TwK_DUXW07RKCcozN1akuOw86q2O86J23s16PtcrVl3_iGhwjrHfOFUNvBDukenKcinB6Dd4tgz6aFacOCeIJSphJzcI7UCKIEyl9VBNIZDAQMqQBq_MyITTslq7DiuikcapUfBlZCnQvWgTOBfinQmo-Tub3ocAZjted5EBnU8vZncLRMftqahLNpmxyPLbgAQf2RvIT9n5Jko_4Io8"
                },
                success: function(res) {
                    console.log('====================================');
                    console.log(res);
                    console.log('====================================');
                }
            });

            // $.ajax({
            //     type: 'get',
            //     url: 'http://myeghamat.com/api/form/2',
            //     headers: {
            //         'Accept': 'application/json',
            //         'Content-Type': 'application/json',
            //         "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiZTUxMDZjOTNiNGEzOTc5ODdmNjI0ZDllMTYyMGFiNzNkNjM0Y2IzOTA2YTRlNThmOTY3NGQxZDliMzVjYmY5OTE3MmUyMGUzODAxYjBmOTAiLCJpYXQiOjE2ODUxODQyNjcuOTkzNDE3LCJuYmYiOjE2ODUxODQyNjcuOTkzNDIyLCJleHAiOjE3MTY4MDY2NjcuNzgzODkzLCJzdWIiOiIxNCIsInNjb3BlcyI6W119.ieMJMIypKQF-u6-RbyyjQ-IuZsK31o92D7pIh4YHAX0GD8iKUKF9dnZ0cWDtA85cGcNVxTsdL908fmDKB8IyU5ZzfOQC1KBTMaQ8d8-uXafnJfJHFs9sJ8DDap1yoCn7FwHh-ICOYwSiWcZmwcbMYXyA-Vr8ltALZgSSqKHNLw0AfxOd2WColEGpudpnRb5ZSu59t6WnjUMuTlW1qQKjUv2lcuIQMsdTSOIiEDLfAYU1uReWKobNzv3VgiLINLfKNRfopJU7rSWE9qeC5RTXIxh5hR-ojp64hC_vO4KAMJMDjJEtB6y6TQczDSqU7GCupuY5ff2ZNHrKKcAVCrKhhenhWfViJvDVpYdEdyoI_8nvhlCpAVFSvDn6M344RuoTlPJzg8UHsEc-anEO16ihff3VAbo41vy0ZA7WPGWi8JxDajJeMPcl_IGtGwMkTPbNM2NP45-zQWjdr54GgEL2b11TwK_DUXW07RKCcozN1akuOw86q2O86J23s16PtcrVl3_iGhwjrHfOFUNvBDukenKcinB6Dd4tgz6aFacOCeIJSphJzcI7UCKIEyl9VBNIZDAQMqQBq_MyITTslq7DiuikcapUfBlZCnQvWgTOBfinQmo-Tub3ocAZjted5EBnU8vZncLRMftqahLNpmxyPLbgAQf2RvIT9n5Jko_4Io8"
            //     },
            //     success: function(res) {
            //         console.log('====================================');
            //         console.log(res);
            //         console.log('====================================');
            //     }
            // });

        });
    </script>


    </body>

</html>
