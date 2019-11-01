let $ = require("jquery");
import Vue from 'vue';
import VueResource from 'vue-resource';
import cookies from 'browser-cookies';
import swal from 'sweetalert';
import {APP_CONFIG} from '../config';

Vue.use(VueResource);

Vue.config.productionTip = false;
Vue.http.options.root = APP_CONFIG.APP_API_LOCATION;
const csrf = cookies.get('XSRF-TOKEN')
Vue.http.options.headers = {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
    'x-xsrf-token': csrf,
};

let SocketConnection = new WebSocket(APP_CONFIG.WEB_SOCKET_LOCATION);

new Vue({
    el: '#app',
    data: {
        JWT: null,
        recipient_id: user_id,
        message: "Test Msg",
    },
    mounted() {
        /* Get Data From Rest API */
        Vue.http.get("test/101")
            .then(
                response => {
                    return response.json();
                },
                error => {
                    console.log(error);
                }
            )
            .then(data => {
                console.log('token received',data);
                this.JWT = data.token;
                /* Connect to WebSocket */
                let client = {
                    Token: this.JWT,
                    user_id: this.JWT,
                    broadcast:true,
                    recipient_id: '',
                    displayName: 'User_'+user_id,
                    message: 'Connected'
                };
                SocketConnection.onopen = function (e) {
                    SocketConnection.send(JSON.stringify(client));
                    $('#messages').append('<font color="green">Successfully connected as user ' + client.displayName + '</font><br>');
                    console.log('Connected')
                };

                SocketConnection.onclose = function (e) {
                    console.log('Closed')
                };

                SocketConnection.onmessage = function (e) {
                    console.log('Setting On Msg')

                    var data = JSON.parse(e.data);
                    console.log(data)
                    if (data.message) {
                        $('#messages').append(data.displayName + ' : ' + data.message + '<br>');
                    }
                };

                /* WebSocket End */
            });
        /* End Data From Rest API */

    },
    methods: {
        test() {
            Vue.http.headers.common["Authorization"] = this.JWT;
            Vue.http.post("test")
                .then(
                    response => {
                        return response.json();
                    },
                    error => {
                        console.log(error);
                    }
                )
                .then(data => {
                    console.log(data)
                    swal(data.message);
                });
        },
        SocketMSG(){
            let client = {
                Token: this.JWT,
                user_id: this.JWT,
                displayName: 'User_'+user_id,
                recipient_id: parseInt(this.recipient_id),
                message: this.message
            };

            console.log(client)
            SocketConnection.send(JSON.stringify(client));
        }

    }
})


