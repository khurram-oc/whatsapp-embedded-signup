<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Page Title</title>
    <script>
        window.fbAsyncInit = function () {
            // JavaScript SDK configuration and setup
            FB.init({
                appId:    '781812423810505', // Facebook App ID
                cookie:   true, // enable cookies
                xfbml:    true, // parse social plugins on this page
                version:  'v19.0' //Graph API version
            });
        };

        // Load the JavaScript SDK asynchronously
        (function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));

        // Facebook Login with JavaScript SDK
        function launchWhatsAppSignup() {
            // Conversion tracking code
            let fbq;
            fbq && fbq('trackCustom', 'WhatsAppOnboardingStart', {appId: '781812423810505', feature: 'whatsapp_embedded_signup'});

            // Launch Facebook login
            FB.login(function (response) {
                if (response.authResponse) {
                    const code = response.authResponse.code;
                    // The returned code must be transmitted to your backend,
                    // which will perform a server-to-server call from there to our servers for an access token
                } else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {
                config_id: '397669909391589', // configuration ID goes here
                response_type: 'code',    // must be set to 'code' for System User access token
                scope: "business_management, whatsapp_business_management, whatsapp_business_messaging",
                override_default_response_type: true, // when true, any response types passed in the "response_type" will take precedence over the default types
                extras: {
                    sessionInfoVersion: 2,  //  Receive Session Logging Info
                }
            });
        }
        const sessionInfoListener = (event) => {
            console.log(event,'testing')
            if (event.origin !== "https://www.facebook.com") return;
            try {
                const data = JSON.parse(event.data);
                if (data.type === 'WA_EMBEDDED_SIGNUP') {
                    // if user finishes the Embedded Signup flow
                    console.log(data.data)
                    if (data.event === 'FINISH') {
                        const {phone_number_id, waba_id} = data.data;
                        console.log(phone_number_id,waba_id)
                    }
                    // if user cancels the Embedded Signup flow
                    else {
                        const{current_step} = data.data;
                        console.log(current_step)
                    }
                }
            } catch {
                // Don’t parse info that’s not a JSON
                console.log('Non JSON Response', event.data);
            }
        };

        window.addEventListener('message', sessionInfoListener);
    </script>
</head>
<body>
<button onclick="launchWhatsAppSignup()" style="background-color: #1877f2; border: 0; border-radius: 4px; color: #fff; cursor: pointer; font-family: Helvetica, Arial, sans-serif; font-size: 16px; font-weight: bold; height: 40px; padding: 0 24px;">Login with Facebook</button>
</body>
</html>
