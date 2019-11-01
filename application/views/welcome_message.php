<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Codeigniter VueJS Webpack Boilerplate</title>

    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/main.css">
</head>
<body>
<div id="app">
    <div id="container">
        <h1>Test Web Socket!</h1>
        <div id="body">
            <div id="messages"></div>
            <input type="text" id="text" v-model="message" placeholder="Message ..">
            <input type="text" id="recipient_id" v-model="recipient_id" placeholder="Recipient id ..">
            <button id="submit" @click="SocketMSG()">Send</button>
        </div>

        <hr>

        <h1>Rest Api Test!</h1>
        <div id="body">
            <p>
                <button @click="test()">Clict to Test Rest Api</button>
            </p>
        </div>

        <p class="footer">Page rendered in <strong>{elapsed_time}</strong>
            seconds. <?php echo (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>' . CI_VERSION . '</strong>' : '' ?>
        </p>
    </div>

</div>
<script>
    var user_id = <?php echo $user_id; ?>;
</script>
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>

</body>
</html>