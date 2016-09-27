<?php

if ( ! defined('FORMZU_PLUGIN_PATH') ) {
    die();
}

function add_formzu_stylesheet() {
?>
    <style>
        .formzu-mail-icon {
            display: inline-block;
            position: relative;
            vertical-align: sub;
            margin: 0 12px 0 0;
        }
        .formzu-mail-icon > i.fa-exclamation-circle {
            position: absolute;
            right: -5;
            background-color: #f1f1f1;
        }
        .red-alert {
            color: #EA0000;
            font-size: 16px;
            font-family: "Meiryo","MS PGothic", Arial, "ヒラギノ角ゴ Pro W3", sans-serif;
        }

        #formzu-create-box.closed,
        #formzu-add-box.closed,
        #formzu-list-box.closed {
            margin-bottom: 50px;
        }

        #formzu-create-box > h2,
        #formzu-add-box > h2,
        #formzu-list-box > h2,
        .separate-box {
            color: #555;
            text-shadow: 1px 1px 1px #ccc;
            border: solid #777;
            padding: 24px 20px;
            border-width: 4px 4px 0;
            letter-spacing: 0.1em;
            font-size: 24px;
            font-weight: bold;
            font-family: "Meiryo","MS PGothic", Arial, "ヒラギノ角ゴ Pro W3", sans-serif;
        }

        #formzu-create-box > div.inside,
        #formzu-add-box > div.inside {
            font-family: "Meiryo","MS PGothic", Arial, "ヒラギノ角ゴ Pro W3", sans-serif;
        }
        #formzu-list-box .tablenav {
            margin: 0 0 4px;
        }
        
        #formzu-create-box.closed h2,
        #formzu-add-box.closed h2,
        #formzu-list-box.closed h2 {
            padding: 16px 16px;
            border-width: 4px 4px 4px;
            cursor: pointer;
        }

        #formzu-create-box h2 > span,
        #formzu-add-box h2 > span,
        #formzu-list-box h2 > span {
            margin: 0 0 0 12px;
        }

        #formzu-create-box.closed .box-icon,
        #formzu-add-box.closed .box-icon,
        #formzu-list-box.closed .box-icon {
            font-size: 2.6em;
            color: #999;
            vertical-align: middle;
            margin: 0 12px 12px 0;
        }

        #formzu-create-box .inside,
        #formzu-add-box .inside,
        #formzu-list-box .inside {
            margin: 0;
            border: solid #777;
            border-width: 0 4px 4px;
        }

        #formzu-list-box {
            background: inherit;
        }
        #formzu-list-box h2 {
            background: white;
        }

        #formzu-create-box .panel,
        #formzu-add-box .panel,
        #formzu-list-box .panel {
            margin: 0px;
            padding: 20px;
        }

        .panel {
            position: relatice;
            overflow: auto;
            background: #fff;
            font-size: 13px;
            line-height: 2.1em;
        }

        .separate-arrow i {
            position: relative;
            left: 43%;
        }

        div.separate-box {
            width: 100%;
            font-size: 22px;
            border-width: 0px;
            padding: 8px 0;
            line-height: 1.4;
            display: inline-block;
            text-align: center;
        }

        #add-new-form-input {
            font-size: 1.6em;
            border: 3px solid #999;
            width: 70%;
            padding: 8px 8px;
            border-radius: 6px;
        }
        #add-new-form-input:hover {
            background-color: rgba(100, 100, 100, 0.1);
        }
        #add-new-form-input:focus {
            outline: none;
            border: 3px solid #777;
            box-shadow: 0 0 6px 0 #777;
        }
        #add-new-form-input::-moz-input-placeholder {
            color: #bbb;
        }
        #add-new-form-input::-webkit-input-placeholder {
            color: #bbb;
        }

        .large-button {
            background-color: #aaa;
            color: #fff;
            cursor: pointer;
            padding: 12px;
            font-size: 1.4em;
            border-radius: 6px;
            vertical-align: baseline;
        }
        .large-button:hover {
            background-color: #000000;
            text-decoration: underline;
            opacity: 0.6;
        }

        i {
            width: 1.2857142857142858em;
            text-align: center;
        }

        .new-item {
            color: red;
            margin-right: 4px;
        }
    </style>

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">

<?php
}

