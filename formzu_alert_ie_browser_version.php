<?php


function formzu_alert_ie_browser_version() {
    global $is_IE;
    ?>
    <script>
        var is_IE = <?php echo esc_js($is_IE); ?>;
        if (is_IE) {
            var version = window.navigator.appVersion.toLowerCase();
            var ver = version.substr(version.indexOf('msie') + 5, 1);
            if (ver != 9 && ver != 1) {
                alert('お使いのブラウザはサポートが終了しています。\nブラウザを最新版にアップグレードするか、\n他のWebブラウザーに移行してください。');
            }
        }
    </script>
    <?php
}

