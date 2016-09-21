<?php


function alert_ie_browser_version() {
    ?>
    <script>
        var user_agent = window.navigator.userAgent.toLowerCase();
        if (user_agent.indexOf('msie') != -1) {
            var version = window.navigator.appVersion.toLowerCase();
            var ver = version.substr(version.indexOf('msie') + 5, 1);
            if (ver != 9 && ver != 1) {
                alert('お使いのブラウザはサポートが終了しています。\nブラウザを最新版にアップグレードするか、\n他のWebブラウザーに移行してください。');
            }
        }
    </script>
    <?php
}

