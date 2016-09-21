<?php

function add_formzu_admin_stylesheet() {
?>
    <style>
        .my-error {
            border-color: #dc3232;
            animation: fadeOutErrorColor 1s ease 0s 1 normal;
            -moz-animation: fadeOutErrorColor 1s ease 0s 1 normal;
            -webkit-animation: fadeOutErrorColor 1s ease 0s 1 normal;
        }
        @keyframes fadeOutErrorColor {
            0% {
                background-color: #dc3232;
                color: white;
            }
            100% {
                background-color: #fff;
                color: #444;
            }
        }
        @-moz-keyframes fadeOutErrorColor {
            0% {
                background-color: #dc3232;
                color: white;
            }
            100% {
                background-color: #fff;
                color: #444;
            }
        }
        @-webkit-keyframes fadeOutErrorColor {
            0% {
                background-color: #dc3232;
                color: white;
            }
            100% {
                background-color: #fff;
                color: #444;
            }
        }

        .my-updated {
            border-color: #46b450;
            animation: fadeOutUpdatedColor 1s ease 0s 1 normal;
            -moz-animation: fadeOutUpdatedColor 1s ease 0s 1 normal;
            -webkit-animation: fadeOutUpdatedColor 1s ease 0s 1 normal;
        }
        @keyframes fadeOutUpdatedColor {
            0% {
                background-color: #46b450;
                color: white;
            }
            100% {
                background-color: #fff;
                color: #444;
            }
        }
        @-moz-keyframes fadeOutUpdatedColor {
            0% {
                background-color: #46b450;
                color: white;
            }
            100% {
                background-color: #fff;
                color: #444;
            }
        }
        @-webkit-keyframes fadeOutUpdatedColor {
            0% {
                background-color: #46b450;
                color: white;
            }
            100% {
                background-color: #fff;
                color: #444;
            }
        }

        .new-item {
            color: red;
            margin-right: 4px;
        }

        .formzu-radiogroup label {
            margin: 0 4px;
        }

        .formzu-radiogroup input[type=radio]:checked + span {
            font-weight: bold;
        }

        .formzu-help-tabs-wrap > div[id^="help-tab"] {
            min-height: 200px;
            max-height: 600px;
        }

        .hide {
            display: none;
        }
    </style>
<?php
}

