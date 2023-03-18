@if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies)

    @include('cookieConsent::dialogContents')

    <script>
        window.laravelCookieConsent = (function () {

            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '{{ config('session.domain') ?? request()->getHost() }}';

            function consentWithCookies() {     
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', COOKIE_VALUE, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }
            
            function notConsentWithCookies() {
                setCookie('{{ $cookieConsentConfig['cookie_name'] }}', -1, {{ $cookieConsentConfig['cookie_lifetime'] }});
                hideCookieDialog();
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');
                    for (let i = 0; i < dialogs.length; ++i) {
                    var fadeEffect = setInterval(function () {
                        if (!dialogs[i].style.opacity) {
                            dialogs[i].style.opacity = 1;
                        }
                        if (dialogs[i].style.opacity > 0) {
                            dialogs[i].style.opacity -= 0.1;
                        } else {
                            clearInterval(fadeEffect);
                        }
                    }, 100);                    
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/{{ config('session.secure') ? ';secure' : null }}'
                    + '{{ config('session.same_site') ? ';samesite='.config('session.same_site') : null }}';
            }

            if (cookieExists('{{ $cookieConsentConfig['cookie_name'] }}')) {
                hideCookieDialog();
            }

            const buttons = document.getElementsByClassName('js-cookie-consent-agree');
            const disagree = document.getElementsByClassName('js-cookie-consent-disagree');

            for (let i = 0; i < buttons.length; ++i) {
                buttons[i].addEventListener('click', consentWithCookies);
            }
            
            for (let i = 0; i < disagree.length; ++i) {
                disagree[i].addEventListener('click', notConsentWithCookies);
            }

            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

@endif
