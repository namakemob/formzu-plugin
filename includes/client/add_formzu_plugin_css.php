<?php

function add_formzu_plugin_css() {
?>
    <?php add_thickbox(); ?>
    <style>
        #TB_window {
            animation: fadeIn 0.5s ease 0s 1 normal;
            -moz-animation: fadeIn 0.5s ease 0s 1 normal;
            -webkit-animation: fadeIn 0.5s ease 0s 1 normal;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0
            }
            100% {
                opacity: 1
            }
        }
        @-moz-keyframes fadeIn {
            0% {
                opacity: 0
            }
            100% {
                opacity: 1
            }
        }
        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0
            }
            100% {
                opacity: 1
            }
        }

        section.formzu-fixed-widget {
            position: fixed;
            width: auto;
            right: 0;
            bottom: 20;
            margin: 0 20px 20px 20px;
            padding: 0;
        }
    </style>
<?php
}

